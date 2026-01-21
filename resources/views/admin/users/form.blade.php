<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($user) ? 'Editar Usuario' : 'Nuevo Usuario' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" 
                          method="POST">
                        @csrf
                        @if(isset($user))
                            @method('PUT')
                        @endif

                        <div class="space-y-6">
                            <!-- Nombre -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nombre Completo *
                                </label>
                                <input type="text" name="name" id="name" 
                                       value="{{ old('name', $user->name ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Correo Electrónico *
                                </label>
                                <input type="email" name="email" id="email" 
                                       value="{{ old('email', $user->email ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Rol -->
                            <div>
                                <label for="role_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Rol *
                                </label>
                                <select name="role_id" id="role_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 @error('role_id') border-red-500 @enderror">
                                    <option value="">Selecciona un rol</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" 
                                                {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contraseña -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Contraseña {{ isset($user) ? '' : '*' }}
                                </label>
                                <input type="password" name="password" id="password" 
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 @error('password') border-red-500 @enderror">
                                @if(isset($user))
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Deja en blanco si no deseas cambiar la contraseña
                                    </p>
                                @endif
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Confirmar Contraseña {{ isset($user) ? '' : '*' }}
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            </div>

                            <!-- Usuario Bloqueado -->
                            <div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="blocked" id="blocked" value="1"
                                           {{ old('blocked', $user->blocked ?? false) ? 'checked' : '' }}
                                           class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-red-600">
                                    <label for="blocked" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Usuario bloqueado
                                    </label>
                                </div>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Los usuarios bloqueados no podrán iniciar sesión
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.users.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ isset($user) ? 'Actualizar' : 'Crear' }} Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>