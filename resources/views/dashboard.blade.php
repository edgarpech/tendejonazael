@extends('layouts.app')

@section('title', 'Dashboard - Tendejón Azael')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Bienvenido de vuelta, {{ auth()->user()->name }}</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('admin.products.index') }}" class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-lg p-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Productos</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['products'] }}</p>
                    <p class="text-xs text-green-600 dark:text-green-400">{{ $stats['active_products'] }} activos</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.categories.index') }}" class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-500 rounded-lg p-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Categorías</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['categories'] }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.brands.index') }}" class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-lg p-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Marcas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['brands'] }}</p>
                </div>
            </div>
        </a>

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-orange-500 rounded-lg p-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Usuarios</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['users'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Products -->
    @if($recent_products->count() > 0)
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Productos Recientes</h2>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Ver todos →</a>
        </div>
        <div id="recentGrid" class="p-2"></div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(function() {
    var recentData = @json($recent_products);

    $('#recentGrid').dxDataGrid({
        dataSource: recentData,
        keyExpr: 'id_product',
        showBorders: false,
        showRowLines: true,
        rowAlternationEnabled: true,
        columnAutoWidth: true,
        wordWrapEnabled: true,
        columns: [
            {
                dataField: 'main_image_url',
                caption: '',
                width: 50,
                allowSorting: false,
                allowFiltering: false,
                cellTemplate: function(container, options) {
                    var src = options.value ? '/storage/' + options.value : '/images/logos/logo.webp';
                    $('<img>').attr('src', src).addClass('w-10 h-10 rounded object-cover').appendTo(container);
                }
            },
            { dataField: 'name', caption: 'Producto' },
            {
                dataField: 'category.name',
                caption: 'Categoría',
                calculateCellValue: function(data) { return data.category ? data.category.name : 'Sin categoría'; }
            },
            {
                dataField: 'brand.name',
                caption: 'Marca',
                calculateCellValue: function(data) { return data.brand ? data.brand.name : 'Sin marca'; }
            },
            {
                dataField: 'price',
                caption: 'Precio',
                dataType: 'number',
                format: { type: 'currency', precision: 2, currency: 'MXN' },
                customizeText: function(e) { return '$' + parseFloat(e.value || 0).toFixed(2); }
            },
            {
                dataField: 'is_active',
                caption: 'Estado',
                width: 90,
                alignment: 'center',
                cellTemplate: function(container, options) {
                    var cls = options.value ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                    $('<span>').addClass('px-2 py-1 text-xs rounded-full font-medium ' + cls).text(options.value ? 'Activo' : 'Inactivo').appendTo(container);
                }
            }
        ],
        paging: { enabled: false },
        searchPanel: { visible: false }
    });
});
</script>
@endpush
