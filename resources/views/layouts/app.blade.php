<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    darkMode: localStorage.getItem('darkMode') === 'true',
    toggleDark() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        document.documentElement.classList.toggle('dark', this.darkMode);
        var dxLink = document.getElementById('dx-theme');
        if (dxLink) {
            dxLink.href = this.darkMode
                ? '{{ asset("vendor/devextreme/css/dx.dark.css") }}'
                : '{{ asset("vendor/devextreme/css/dx.light.css") }}';
        }
    }
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Tendejón Azael'))</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/logos/logo.webp') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="{{ asset('vendor/fonts/inter/inter.css') }}" rel="stylesheet">

    {{-- jQuery + DevExtreme --}}
    <script src="{{ asset('vendor/jquery/jquery-3.7.1.min.js') }}"></script>
    <link id="dx-theme" rel="stylesheet" href="">
    <script>
        (function(){
            var d = localStorage.getItem('darkMode') === 'true';
            document.getElementById('dx-theme').href = d
                ? '{{ asset("vendor/devextreme/css/dx.dark.css") }}'
                : '{{ asset("vendor/devextreme/css/dx.light.css") }}';
        })();
    </script>
    <script src="{{ asset('vendor/devextreme/js/dx.all.js') }}"></script>
    <script src="{{ asset('vendor/devextreme/js/dx.messages.es.js') }}"></script>
    <script>DevExpress.localization.locale('es');</script>

    <style>
        .dark .dx-datagrid-headers .dx-datagrid-text-content { color: #e2e8f0; }
        .dx-datagrid .dx-data-row button { cursor: pointer; }
        .dx-popup-wrapper > .dx-overlay-content > .dx-popup-content { overflow-y: auto !important; }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased" x-cloak>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        @auth
            @include('layouts.navigation')
        @endauth

        <main class="@auth py-6 @endauth">
            @yield('content')
        </main>
    </div>

    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        // Fix: capture-phase wheel listener so inner scrollable elements inside
        // DevExtreme popups receive scroll before dxScrollable intercepts them.
        document.addEventListener('wheel', function(e) {
            var el = e.target.closest('.dx-popup-content .overflow-y-auto, .dx-popup-content .overflow-auto');
            if (!el) return;
            if (el.scrollHeight <= el.clientHeight) return;
            var atTop = el.scrollTop === 0 && e.deltaY < 0;
            var atBottom = (el.scrollTop + el.clientHeight >= el.scrollHeight) && e.deltaY > 0;
            if (atTop || atBottom) return;
            el.scrollTop += e.deltaY;
            e.preventDefault();
            e.stopPropagation();
        }, { capture: true, passive: false });
        

        function showToast(message, type) {
            DevExpress.ui.notify({
                message: message,
                type: type || 'info',
                displayTime: 3500,
                width: 'auto',
                position: { my: 'bottom right', at: 'bottom right', of: window, offset: '-20 -20' }
            });
        }

        @if(session('success'))
            $(function(){ showToast(@json(session('success')), 'success'); });
        @endif
        @if(session('error'))
            $(function(){ showToast(@json(session('error')), 'error'); });
        @endif

        $(function(){
            var msg = sessionStorage.getItem('toast_msg');
            if (msg) {
                showToast(msg, sessionStorage.getItem('toast_type') || 'info');
                sessionStorage.removeItem('toast_msg');
                sessionStorage.removeItem('toast_type');
            }
        });

        function ajaxSuccess(message, type) {
            sessionStorage.setItem('toast_msg', message);
            sessionStorage.setItem('toast_type', type || 'success');
            location.reload();
        }

        function handleAjaxError(xhr) {
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                var msgs = Object.values(xhr.responseJSON.errors).flat().join('. ');
                showToast(msgs, 'error');
            } else {
                showToast(xhr.responseJSON?.message || 'Error al procesar la solicitud', 'error');
            }
            // Re-enable any locked DevExtreme save button on error
            var btnSave = $('#btnSave').dxButton('instance');
            if (btnSave) {
                btnSave.option({ disabled: false, text: btnSave._originalText || 'Guardar' });
            }
            var btnSaveProfile = $('#btnSaveProfile').dxButton('instance');
            if (btnSaveProfile) {
                btnSaveProfile.option({ disabled: false, text: btnSaveProfile._originalText || 'Guardar' });
            }
            var btnSavePwd = $('#btnSavePwd').dxButton('instance');
            if (btnSavePwd) {
                btnSavePwd.option({ disabled: false, text: btnSavePwd._originalText || 'Cambiar Contraseña' });
            }
        }

        // Global AJAX button locking: disable DevExtreme save buttons while request is in flight
        $(document).ajaxSend(function() {
            ['#btnSave', '#btnSaveProfile', '#btnSavePwd'].forEach(function(sel) {
                try {
                    var inst = $(sel).dxButton('instance');
                    if (inst) {
                        inst._originalText = inst.option('text');
                        inst.option({ disabled: true, text: 'Procesando...' });
                    }
                } catch(e) {}
            });
        });
        $(document).ajaxComplete(function() {
            ['#btnSave', '#btnSaveProfile', '#btnSavePwd'].forEach(function(sel) {
                try {
                    var inst = $(sel).dxButton('instance');
                    if (inst) {
                        inst.option({ disabled: false, text: inst._originalText || inst.option('text') });
                    }
                } catch(e) {}
            });
        });
    </script>

    @stack('scripts')
</body>
</html>