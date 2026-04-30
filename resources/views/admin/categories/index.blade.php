@extends('layouts.app')

@section('title', 'Categorías - Tendejón Azael')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="admin-title text-2xl font-bold text-gray-900 dark:text-white">Categorías</h1>
            <p class="admin-subtitle text-sm text-gray-500 dark:text-gray-400">Gestión de categorías de productos</p>
        </div>
        @can('categories.create')
        <button onclick="openForm()" class="btn-add inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nueva Categoría
        </button>
        @endcan
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4">
        <table id="dataTable" class="w-full stripe hover"></table>
    </div>
</div>

<!-- Modal -->
<div id="formModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/50" onclick="closeModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4 pointer-events-none">
        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md max-h-[85vh] overflow-y-auto pointer-events-auto">
            <div class="sticky top-0 bg-white dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between z-10">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white"></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 modal-body">
                <form id="catForm" class="space-y-4" onsubmit="return false;">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre *</label>
                        <input type="text" id="fName" class="fi" placeholder="Nombre de la categoría">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                        <textarea id="fDescription" class="fi" rows="3" placeholder="Descripción opcional"></textarea>
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="toggle-switch"><input type="checkbox" id="fActive"><span class="slider"></span></label>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Activo</span>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">Cancelar</button>
                        <button type="button" onclick="saveForm()" class="btn-save px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
var categoriesData = @json($categories);
var canEdit = @json(auth()->user()->can('categories.edit'));
var canDelete = @json(auth()->user()->can('categories.delete'));
var editingId = null;

$(function() {
    $('#dataTable').DataTable({
        data: categoriesData,
        responsive: true,
        language: dtLang,
        pageLength: 10,
        lengthMenu: [10, 15, 25, 50],
        order: [[0, 'asc']],
        columns: [
            { data: 'name', title: 'Nombre' },
            { data: 'description', title: 'Descripción', defaultContent: '', responsivePriority: 5 },
            { data: 'products_count', title: 'Productos', className: 'dt-center', width: '80px' },
            {
                data: 'is_active', title: 'Activo', className: 'dt-center', width: '80px',
                render: function(v) {
                    var cls = v ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-800/40 dark:text-emerald-300' : 'bg-red-100 text-red-700 dark:bg-red-800/40 dark:text-red-300';
                    return '<span class="px-2 py-1 text-xs rounded-full font-medium ' + cls + '">' + (v ? 'Sí' : 'No') + '</span>';
                }
            },
            {
                data: 'id_category', title: 'Acciones', className: 'dt-center', width: '90px', orderable: false, searchable: false,
                render: function(id) {
                    var html = '<div class="flex items-center justify-center gap-1">';
                    if (canEdit) html += '<button onclick="openForm(' + id + ')" class="p-1.5 text-blue-500 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-800/30 rounded" title="Editar"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>';
                    if (canDelete) html += '<button onclick="deleteItem(' + id + ')" class="p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-800/30 rounded" title="Eliminar"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>';
                    html += '</div>';
                    return html;
                }
            }
        ]
    });
});

function openModal() { $('#formModal').removeClass('hidden'); }
function closeModal() { $('#formModal').addClass('hidden'); }

function openForm(id) {
    editingId = id || null;
    var data = id ? categoriesData.find(function(c) { return c.id_category === id; }) : {};
    data = data || {};
    $('#modalTitle').text(id ? 'Editar Categoría' : 'Nueva Categoría');
    $('#fName').val(data.name || '');
    $('#fDescription').val(data.description || '');
    $('#fActive').prop('checked', data.is_active !== undefined ? !!data.is_active : true);
    openModal();
}

function saveForm() {
    var formData = {
        name: $('#fName').val(),
        description: $('#fDescription').val(),
        is_active: $('#fActive').is(':checked') ? 1 : 0
    };
    if (editingId) formData._method = 'PUT';

    $.ajax({
        url: editingId ? '/admin/categories/' + editingId : '/admin/categories',
        method: 'POST',
        data: formData,
        success: function(res) { closeModal(); ajaxSuccess(res.message); },
        error: handleAjaxError
    });
}

function deleteItem(id) {
    confirmAction('¿Estás seguro de que deseas eliminar esta categoría?').then(function(r) {
        if (r.isConfirmed) {
            $.ajax({
                url: '/admin/categories/' + id,
                method: 'DELETE',
                success: function(res) { ajaxSuccess(res.message); },
                error: handleAjaxError
            });
        }
    });
}
</script>
@endpush
