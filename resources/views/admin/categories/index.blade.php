<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Categorías') }}
            </h2>
            <button onclick="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nueva Categoría
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
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Slug
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Productos
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($categories as $category)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $category->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $category->slug }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $category->products_count }} productos
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $category->active ? 'Activa' : 'Inactiva' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end gap-2">
                                                <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}', {{ $category->active ? 'true' : 'false' }})" 
                                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">
                                                    Editar
                                                </button>
                                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No se encontraron categorías
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="categoryModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100 mb-4" id="modalTitle">
                    Nueva Categoría
                </h3>
                <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <input type="hidden" id="categoryId" name="category_id">
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    
                    <div class="mb-4">
                        <label for="categoryName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nombre *
                        </label>
                        <input type="text" name="name" id="categoryName" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    </div>

                    <div class="mb-4">
                        <label for="categoryDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Descripción
                        </label>
                        <textarea name="description" id="categoryDescription" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"></textarea>
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="active" id="categoryActive" value="1" checked
                                   class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-blue-600">
                            <label for="categoryActive" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Categoría activa
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
            document.getElementById('categoryModal').classList.remove('hidden');
            document.getElementById('modalTitle').textContent = 'Nueva Categoría';
            document.getElementById('categoryForm').action = '{{ route("admin.categories.store") }}';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('categoryForm').reset();
            document.getElementById('categoryActive').checked = true;
        }

        function closeModal() {
            document.getElementById('categoryModal').classList.add('hidden');
        }

        function editCategory(id, name, description, active) {
            document.getElementById('categoryModal').classList.remove('hidden');
            document.getElementById('modalTitle').textContent = 'Editar Categoría';
            document.getElementById('categoryForm').action = '/admin/categories/' + id;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('categoryName').value = name;
            document.getElementById('categoryDescription').value = description || '';
            document.getElementById('categoryActive').checked = active;
        }

        // Cerrar modal al hacer clic fuera
        window.onclick = function(event) {
            const modal = document.getElementById('categoryModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</x-app-layout>