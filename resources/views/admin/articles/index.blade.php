@extends('layouts.app')

@section('title', 'Artículos - Tendejón Azael')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="admin-title text-2xl font-bold text-gray-900 dark:text-white">Artículos</h1>
            <p class="admin-subtitle text-sm text-gray-500 dark:text-gray-400">Gestión de artículos del blog</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="btn-add inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo Artículo
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4">
        <table id="dataTable" class="w-full stripe hover"></table>
    </div>
</div>
@endsection

@push('scripts')
<script>
var articlesData = @json($articles);

$(function() {
    $('#dataTable').DataTable({
        data: articlesData,
        responsive: true,
        language: dtLang,
        pageLength: 10,
        lengthMenu: [10, 15, 25, 50],
        order: [[4, 'desc']],
        columns: [
            {
                data: 'image', title: 'Imagen', width: '60px', orderable: false, searchable: false, responsivePriority: 10001,
                render: function(v) {
                    var src = v ? '/' + v : '/images/logos/logo.webp';
                    return '<img src="' + src + '" class="dt-thumb" alt="" style="width:50px;height:35px;object-fit:cover;border-radius:6px;">';
                }
            },
            { data: 'title', title: 'Título', responsivePriority: 1 },
            {
                data: 'category', title: 'Categoría', responsivePriority: 5,
                render: function(v) {
                    return '<span class="px-2 py-1 text-xs rounded-full font-medium bg-cyan-100 text-cyan-700 dark:bg-cyan-800/40 dark:text-cyan-300 capitalize">' + (v || '') + '</span>';
                }
            },
            {
                data: 'is_published', title: 'Estado', className: 'dt-center', width: '100px', responsivePriority: 4,
                render: function(v) {
                    var cls = v ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-800/40 dark:text-emerald-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-800/40 dark:text-amber-300';
                    return '<span class="px-2 py-1 text-xs rounded-full font-medium ' + cls + '">' + (v ? 'Publicado' : 'Borrador') + '</span>';
                }
            },
            {
                data: 'published_at', title: 'Fecha', responsivePriority: 6,
                render: function(v) {
                    if (!v) return '<span class="text-gray-400">—</span>';
                    var d = new Date(v);
                    return d.toLocaleDateString('es-MX', { day: '2-digit', month: 'short', year: 'numeric', timeZone: 'UTC' });
                }
            },
            {
                data: 'id_article', title: 'Acciones', className: 'dt-center', width: '120px', orderable: false, searchable: false, responsivePriority: 3,
                render: function(id) {
                    var slug = articlesData.find(function(a) { return a.id_article === id; });
                    var previewUrl = slug ? '/blog/' + slug.slug : '#';
                    return '<div class="flex items-center justify-center gap-1">' +
                        '<a href="' + previewUrl + '" target="_blank" class="p-1.5 text-gray-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800/30 rounded" title="Ver"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></a>' +
                        '<a href="/admin/articles/' + id + '/edit" class="p-1.5 text-blue-500 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-800/30 rounded" title="Editar"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>' +
                        '<button onclick="deleteItem(' + id + ')" class="p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-800/30 rounded" title="Eliminar"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>' +
                    '</div>';
                }
            }
        ]
    });
});

function deleteItem(id) {
    confirmAction('¿Estás seguro de que deseas eliminar este artículo?').then(function(r) {
        if (r.isConfirmed) {
            $.ajax({
                url: '/admin/articles/' + id,
                method: 'DELETE',
                success: function(res) { ajaxSuccess(res.message); },
                error: handleAjaxError
            });
        }
    });
}
</script>
@endpush
