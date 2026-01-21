<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Marcas') }}
            </h2>
            <button onclick="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nueva Marca
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($brands as $brand)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 flex flex-col justify-between">
                                @if($brand->logo)
                                    <div class="mb-3 flex justify-center">
                                        <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" 
                                             class="h-20 object-contain">
                                    </div>
                                @endif
                                <h3 class="text-lg font-semibold text-center mb-2">{{ $brand->name }}</h3>
                                @if($brand->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ Str::limit($brand->description, 100) }}</p>
                                @endif
                                <div class="flex justify-between items-center mt-auto">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $brand->products_count }} productos
                                    </span>
                                    <div class="flex gap-2">
                                        <button onclick="editBrand({{ $brand->id }}, '{{ $brand->name }}', '{{ $brand->description }}', {{ $brand->active ? 'true' : 'false' }})" 
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 text-sm">
                                            Editar
                                        </button>
                                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 text-sm">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-500 dark:text-gray-400 py-8">
                                No se encontraron marcas
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal similar al de categorías -->
    <div id="brandModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100 mb-4" id="modalTitle">
                    Nueva Marca
                </h3>
                <form id="brandForm" method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="brandId" name="brand_id">
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    
                    <div class="mb-4">
                        <label for="brandName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nombre *
                        </label>
                        <input type="text" name="name" id="brandName" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    </div>

                    <div class="mb-4">
                        <label for="brandLogo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Logo
                        </label>
                        <input type="file" name="logo" id="brandLogo" accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400">
                    </div>

                    <div class="mb-4">
                        <label for="brandDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Descripción
                        </label>
                        <textarea name="description" id="brandDescription" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"></textarea>
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="active" id="brandActive" value="1" checked
                                   class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-blue-600">
                            <label for="brandActive" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Marca activa
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('brandModal').classList.remove('hidden');
            document.getElementById('modalTitle').textContent = 'Nueva Marca';
            document.getElementById('brandForm').action = '{{ route("admin.brands.store") }}';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('brandForm').reset();
            document.getElementById('brandActive').checked = true;
        }

        function closeModal() {
            document.getElementById('brandModal').classList.add('hidden');
        }

        function editBrand(id, name, description, active) {
            document.getElementById('brandModal').classList.remove('hidden');
            document.getElementById('modalTitle').textContent = 'Editar Marca';
            document.getElementById('brandForm').action = '/admin/brands/' + id;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('brandName').value = name;
            document.getElementById('brandDescription').value = description || '';
            document.getElementById('brandActive').checked = active;
        }

        window.onclick = function(event) {
            const modal = document.getElementById('brandModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</x-app-layout>