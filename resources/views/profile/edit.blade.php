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
                <input type="text" id="fName" class="fi" value="{{ $user->name }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo Electrónico</label>
                <input type="email" id="fEmail" class="fi" value="{{ $user->email }}">
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm text-gray-500 dark:text-gray-400">
                <div><span class="font-medium">Rol:</span> {{ $user->role->display_name ?? 'Sin rol' }}</div>
                <div><span class="font-medium">Último acceso:</span> {{ $user->last_login_at ? $user->last_login_at->timezone('America/Merida')->format('d/m/Y, h:i a') : 'N/A' }}</div>
            </div>
            <div class="flex justify-end">
                <button type="button" id="btnSaveProfile" class="btn-save px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Guardar Cambios</button>
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
                <input type="password" id="fCurrentPwd" class="fi" placeholder="Contraseña actual">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nueva Contraseña</label>
                <input type="password" id="fNewPwd" class="fi" placeholder="Mínimo 8 caracteres">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Nueva Contraseña</label>
                <input type="password" id="fConfirmPwd" class="fi" placeholder="Repetir nueva contraseña">
            </div>
            <div class="flex justify-end">
                <button type="button" id="btnSavePwd" class="btn-save px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">Cambiar Contraseña</button>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#btnSaveProfile').on('click', function() {
        $.ajax({
            url: '{{ route("profile.update") }}',
            method: 'PUT',
            data: {
                name: $('#fName').val(),
                email: $('#fEmail').val()
            },
            success: function() { ajaxSuccess('Datos actualizados correctamente'); },
            error: handleAjaxError
        });
    });

    $('#btnSavePwd').on('click', function() {
        $.ajax({
            url: '{{ route("profile.password") }}',
            method: 'PUT',
            data: {
                current_password: $('#fCurrentPwd').val(),
                password: $('#fNewPwd').val(),
                password_confirmation: $('#fConfirmPwd').val()
            },
            success: function() { ajaxSuccess('Contraseña actualizada correctamente'); },
            error: handleAjaxError
        });
    });
});
</script>
@endpush
