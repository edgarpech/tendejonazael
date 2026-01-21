@extends('layouts.app')

@section('title', 'Iniciar Sesión - Tendejón Azael')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-primary-600 to-purple-700">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">
                    Tendejón Azael
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Panel Administrativo
                </p>
            </div>
            
            @if($errors->any())
                <div class="mt-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                @foreach($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </h3>
                        </div>
                    </div>
                </div>
            @endif
            
            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Correo Electrónico
                        </label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               value="{{ old('email') }}"
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 sm:text-sm"
                               placeholder="correo@ejemplo.com">
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Contraseña
                        </label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 sm:text-sm"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                            Recordarme
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 transform hover:scale-105">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-primary-500 group-hover:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </span>
                        Iniciar Sesión
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center text-xs text-gray-500 dark:text-gray-400">
                <p>Credenciales de prueba:</p>
                <p class="mt-1">Admin: admin@tendejonazael.com / admin123</p>
                <p>Trabajador: trabajador@tendejonazael.com / trabajador123</p>
            </div>
        </div>
    </div>
</div>
@endsection