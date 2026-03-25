<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    darkMode: localStorage.getItem('darkMode') === 'true',
    toggleDark() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        document.documentElement.classList.toggle('dark', this.darkMode);
    }
}" :class="{ 'dark': darkMode }">
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6130FGQMRE"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','G-6130FGQMRE');</script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TF6JZMCQ');</script>
<!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Tendejón Azael'))</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/logos/logo.webp') }}">

    {{-- DataTables vendor CSS loads first--}}
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/responsive.dataTables.min.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="{{ asset('vendor/fonts/inter/inter.css') }}" rel="stylesheet">

    {{-- jQuery --}}
    <script src="{{ asset('vendor/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.responsive.min.js') }}"></script>

    {{-- SweetAlert2 --}}
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>

    @stack('styles')
</head>
<body class="font-sans antialiased" x-cloak>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TF6JZMCQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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

        var dtLang = {
            search: "", lengthMenu: "Mostrar _MENU_", info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Sin registros", infoFiltered: "(de _MAX_)", zeroRecords: "Sin resultados",
            emptyTable: "No hay datos", paginate: { first: "«", last: "»", next: "›", previous: "‹" }
        };

        // Add placeholder to DataTables search inputs + move length to bottom on mobile
        $(document).on('init.dt', function(e, settings) {
            var $container = $(settings.nTableWrapper);
            $container.find('.dt-search input').attr('placeholder', 'Buscar...');

            // On mobile: move length selector to bottom row
            if (window.innerWidth < 768) {
                var $length = $container.find('.dt-length');
                var $bottomRow = $container.find('.dt-layout-row').last();
                if ($length.length && $bottomRow.length) {
                    $length.detach().prependTo($bottomRow);
                }
            }
        });

        function isDark() {
            return document.documentElement.classList.contains('dark');
        }

        function showToast(message, type) {
            var icon = type === 'success' ? 'success' : type === 'error' ? 'error' : 'info';
            Swal.fire({ toast: true, position: 'bottom-end', icon: icon, title: message, showConfirmButton: false, timer: 3500, timerProgressBar: true, customClass: { popup: 'swal-toast-sm' }, background: isDark() ? '#1f2937' : '#fff', color: isDark() ? '#e5e7eb' : '#545454' });
        }

        function confirmAction(text) {
            return Swal.fire({
                title: 'Confirmar',
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar',
                width: 360,
                background: isDark() ? '#1f2937' : '#fff',
                color: isDark() ? '#e5e7eb' : '#545454'
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
            $('.btn-save').prop('disabled', false).each(function() {
                $(this).text($(this).data('original-text') || 'Guardar');
            });
        }

        $(document).ajaxSend(function() {
            $('.btn-save').each(function() {
                $(this).data('original-text', $(this).text()).prop('disabled', true).text('Procesando...');
            });
        });
        $(document).ajaxComplete(function() {
            $('.btn-save').prop('disabled', false).each(function() {
                $(this).text($(this).data('original-text') || 'Guardar');
            });
        });
    </script>

    @stack('scripts')
</body>
</html>