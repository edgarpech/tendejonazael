@extends('layouts.app')

@section('title', 'Iniciar Sesión - Tendejón Azael')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-slate-800 via-gray-900 to-slate-900" x-data="{ loading: false }">
    <div class="max-w-md w-full">
        <div class="text-center mb-5">
            <img src="{{ asset('images/logos/logo_text.webp') }}" alt="Tendejón Azael" class="h-16 mx-auto">
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 sm:p-10">
            @if($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-red-800 dark:text-red-200">
                            @foreach($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </p>
                    </div>
                </div>
            @endif
            
            <form action="{{ route('login') }}" method="POST" class="space-y-6" @submit="loading = true">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Correo Electrónico
                    </label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           value="{{ old('email') }}"
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent dark:bg-gray-700 text-sm"
                           placeholder="correo@ejemplo.com">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Contraseña
                    </label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent dark:bg-gray-700 text-sm"
                           placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input name="remember" type="checkbox"
                               class="h-4 w-4 text-cyan-600 focus:ring-cyan-500 border-gray-300 dark:border-gray-600 rounded">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Recordarme</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 font-medium cursor-pointer">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                <button type="submit" :disabled="loading"
                        class="w-full flex justify-center items-center gap-2 py-3 px-4 bg-gradient-to-r from-cyan-600 to-blue-700 hover:from-cyan-700 hover:to-blue-800 text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-all duration-200 cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed">
                    <svg x-show="loading" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
                    <svg x-show="!loading" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    <span x-text="loading ? 'Iniciando sesión...' : 'Iniciar Sesión'"></span>
                </button>
            </form>
        </div>

        <p class="text-center text-gray-500 text-xs mt-8">&copy; {{ date('Y') }} Tendejón Azael</p>
    </div>
</div>
@endsection