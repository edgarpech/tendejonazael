<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Productos') }}
            </h2>
            <a href="{{ route('admin.products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nuevo Producto
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Filtros y búsqueda -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <input type="text" name="search" placeholder="Buscar productos..." 
                                   value="{{ request('search') }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        </div>
                        <div>
                            <select name="category_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                <option value="">Todas las categorías</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select name="brand_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                <option value="">Todas las marcas</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex-1">
                                Filtrar
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de productos -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Imagen
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Categoría
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Marca
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Precio
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Stock
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
                                @forelse($products as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded object-cover">
                                            @else
                                                <div class="h-10 w-10 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center">
                                                    <span class="text-gray-400 text-xs">Sin imagen</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $product->name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                SKU: {{ $product->sku }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $product->category->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $product->brand->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            ${{ number_format($product->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm {{ $product->stock > 10 ? 'text-green-600' : ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                                {{ $product->stock }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $product->active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">
                                                    Editar
                                                </a>
                                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
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
                                        <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No se encontraron productos
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>