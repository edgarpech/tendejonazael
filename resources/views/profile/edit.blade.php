@extends('layouts.app')

@section('title', 'Mi Perfil - Tendejón Azael')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Mi Perfil</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Administra tu información personal y contraseña</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Personal Info -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Información Personal</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Actualiza tu nombre y correo electrónico</p>
        </div>
        <div class="p-6 space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre Completo</label>
                <div id="fName"></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo Electrónico</label>
                <div id="fEmail"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm text-gray-500 dark:text-gray-400">
                <div><span class="font-medium">Rol:</span> {{ $user->role->display_name ?? 'Sin rol' }}</div>
                <div><span class="font-medium">Último acceso:</span> {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'N/A' }}</div>
            </div>
            <div class="flex justify-end">
                <div id="btnSaveProfile"></div>
            </div>
        </div>
    </div>

    <!-- Change Password -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Cambiar Contraseña</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Asegúrate de usar una contraseña segura de al menos 8 caracteres</p>
        </div>
        <div class="p-6 space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña Actual</label>
                <div id="fCurrentPwd"></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nueva Contraseña</label>
                <div id="fNewPwd"></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Nueva Contraseña</label>
                <div id="fConfirmPwd"></div>
            </div>
            <div class="flex justify-end">
                <div id="btnSavePwd"></div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#fName').dxTextBox({ value: @json($user->name) });
    $('#fEmail').dxTextBox({ value: @json($user->email), mode: 'email' });

    $('#btnSaveProfile').dxButton({
        text: 'Guardar Cambios',
        type: 'default',
        stylingMode: 'contained',
        onClick: function() {
            $.ajax({
                url: '{{ route("profile.update") }}',
                method: 'PUT',
                data: {
                    name: $('#fName').dxTextBox('instance').option('value'),
                    email: $('#fEmail').dxTextBox('instance').option('value')
                },
                success: function() {
                    ajaxSuccess('Datos actualizados correctamente');
                },
                error: handleAjaxError
            });
        }
    });

    $('#fCurrentPwd').dxTextBox({ value: '', mode: 'password', placeholder: 'Contraseña actual' });
    $('#fNewPwd').dxTextBox({ value: '', mode: 'password', placeholder: 'Mínimo 8 caracteres' });
    $('#fConfirmPwd').dxTextBox({ value: '', mode: 'password', placeholder: 'Repetir nueva contraseña' });

    $('#btnSavePwd').dxButton({
        text: 'Cambiar Contraseña',
        type: 'danger',
        stylingMode: 'contained',
        onClick: function() {
            $.ajax({
                url: '{{ route("profile.password") }}',
                method: 'PUT',
                data: {
                    current_password: $('#fCurrentPwd').dxTextBox('instance').option('value'),
                    password: $('#fNewPwd').dxTextBox('instance').option('value'),
                    password_confirmation: $('#fConfirmPwd').dxTextBox('instance').option('value')
                },
                success: function() {
                    ajaxSuccess('Contraseña actualizada correctamente');
                },
                error: handleAjaxError
            });
        }
    });
});
</script>
@endpush
