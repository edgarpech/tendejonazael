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
            <a href="{{ route('admin.products.index') }}" class="text-sm text-blue-500 dark:text-blue-400 hover:underline">Ver todos →</a>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($recent_products as $product)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                <img src="{{ $product->main_image_url ? asset('storage/' . $product->main_image_url) : asset('images/logos/logo.webp') }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $product->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $product->category?->name ?? 'Sin categoría' }} · {{ $product->brand?->name ?? 'Sin marca' }}</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="font-bold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</p>
                    @if($product->is_active)
                    <span class="text-xs text-emerald-600 dark:text-emerald-400">Activo</span>
                    @else
                    <span class="text-xs text-red-500 dark:text-red-400">Inactivo</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
