<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($product) ? 'Editar Producto' : 'Nuevo Producto' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" 
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($product))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nombre del Producto *
                                </label>
                                <input type="text" name="name" id="name" 
                                       value="{{ old('name', $product->name ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SKU -->
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    SKU *
                                </label>
                                <input type="text" name="sku" id="sku" 
                                       value="{{ old('sku', $product->sku ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 @error('sku') border-red-500 @enderror">
                                @error('sku')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Categoría -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Categoría *
                                </label>
                                <select name="category_id" id="category_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 @error('category_id') border-red-500 @enderror">
                                    <option value="">Selecciona una categoría</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Marca -->
                            <div>
                                <label for="brand_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Marca
                                </label>
                                <select name="brand_id" id="brand_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                    <option value="">Sin marca</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" 
                                                {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Precio -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Precio *
                                </label>
                                <input type="number" name="price" id="price" step="0.01" min="0"
                                       value="{{ old('price', $product->price ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 @error('price') border-red-500 @enderror">
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stock -->
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Stock *
                                </label>
                                <input type="number" name="stock" id="stock" min="0"
                                       value="{{ old('stock', $product->stock ?? 0) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 @error('stock') border-red-500 @enderror">
                                @error('stock')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Precio de Oferta -->
                            <div>
                                <label for="sale_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Precio de Oferta
                                </label>
                                <input type="number" name="sale_price" id="sale_price" step="0.01" min="0"
                                       value="{{ old('sale_price', $product->sale_price ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            </div>

                            <!-- Imagen -->
                            <div class="md:col-span-2">
                                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Imagen del Producto
                                </label>
                                @if(isset($product) && $product->image)
                                    <div class="mt-2 mb-2">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                             class="h-32 w-32 object-cover rounded">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100
                                              dark:file:bg-gray-700 dark:file:text-gray-300">
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Descripción
                                </label>
                                <textarea name="description" id="description" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('description', $product->description ?? '') }}</textarea>
                            </div>

                            <!-- Estado Activo -->
                            <div class="md:col-span-2">
                                <div class="flex items-center">
                                    <input type="checkbox" name="active" id="active" value="1"
                                           {{ old('active', $product->active ?? true) ? 'checked' : '' }}
                                           class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-blue-600">
                                    <label for="active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Producto activo
                                    </label>
                                </div>
                            </div>

                            <!-- Featured -->
                            <div class="md:col-span-2">
                                <div class="flex items-center">
                                    <input type="checkbox" name="featured" id="featured" value="1"
                                           {{ old('featured', $product->featured ?? false) ? 'checked' : '' }}
                                           class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-blue-600">
                                    <label for="featured" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Producto destacado
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.products.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ isset($product) ? 'Actualizar' : 'Crear' }} Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>