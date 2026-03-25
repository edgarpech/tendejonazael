@extends('layouts.app')

@section('title', 'Marcas - Tendejón Azael')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="admin-title text-2xl font-bold text-gray-900 dark:text-white">Marcas</h1>
            <p class="admin-subtitle text-sm text-gray-500 dark:text-gray-400">Gestión de marcas de productos</p>
        </div>
        <button onclick="openForm()" class="btn-add inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nueva Marca
        </button>
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
                <form id="brandForm" class="space-y-4" onsubmit="return false;">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre *</label>
                        <input type="text" id="fName" class="fi" placeholder="Nombre de la marca">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                        <textarea id="fDescription" class="fi" rows="3" placeholder="Descripción opcional"></textarea>
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="toggle-switch"><input type="checkbox" id="fActive"><span class="slider"></span></label>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Activo</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="toggle-switch"><input type="checkbox" id="fShowInHome"><span class="slider"></span></label>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Mostrar en Home</span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Logo</label>
                        <div id="currentLogo" class="mb-2 hidden flex items-center gap-3">
                            <img id="currentLogoPreview" class="w-16 h-16 rounded-lg object-contain bg-gray-50 dark:bg-gray-700 p-1" src="">
                            <button type="button" id="btnDeleteLogo" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium flex items-center gap-1 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Eliminar logo
                            </button>
                        </div>
                        <input type="file" id="logoFile" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300">
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
var brandsData = @json($brands);
var editingId = null;

$(function() {
    $('#dataTable').DataTable({
        data: brandsData,
        responsive: true,
        language: dtLang,
        pageLength: 10,
        lengthMenu: [10, 15, 25, 50],
        order: [[1, 'asc']],
        columns: [
            {
                data: 'logo_url', title: '', width: '50px', orderable: false, searchable: false,
                render: function(v) {
                    var src = v ? '/storage/' + v : '/images/logos/logo.webp';
                    return '<img src="' + src + '" class="w-8 h-8 rounded-lg object-contain">';
                }
            },
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
                data: 'show_in_home', title: 'Home', className: 'dt-center', width: '80px',
                render: function(v) {
                    var cls = v ? 'bg-blue-100 text-blue-700 dark:bg-blue-800/40 dark:text-blue-300' : 'bg-gray-100 text-gray-500 dark:bg-gray-700/40 dark:text-gray-400';
                    return '<span class="px-2 py-1 text-xs rounded-full font-medium ' + cls + '">' + (v ? 'Sí' : 'No') + '</span>';
                }
            },
            {
                data: 'id_brand', title: 'Acciones', className: 'dt-center', width: '90px', orderable: false, searchable: false,
                render: function(id) {
                    return '<div class="flex items-center justify-center gap-1">' +
                        '<button onclick="openForm(' + id + ')" class="p-1.5 text-blue-500 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-800/30 rounded" title="Editar"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>' +
                        '<button onclick="deleteItem(' + id + ')" class="p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-800/30 rounded" title="Eliminar"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>' +
                    '</div>';
                }
            }
        ]
    });
});

function openModal() { $('#formModal').removeClass('hidden'); }
function closeModal() { $('#formModal').addClass('hidden'); }

function openForm(id) {
    editingId = id || null;
    var data = id ? brandsData.find(function(b) { return b.id_brand === id; }) : {};
    data = data || {};
    $('#modalTitle').text(id ? 'Editar Marca' : 'Nueva Marca');
    $('#fName').val(data.name || '');
    $('#fDescription').val(data.description || '');
    $('#fActive').prop('checked', data.is_active !== undefined ? !!data.is_active : true);
    $('#fShowInHome').prop('checked', !!data.show_in_home);
    $('#logoFile').val('');

    if (data.logo_url) {
        $('#currentLogo').removeClass('hidden');
        $('#currentLogoPreview').attr('src', '/storage/' + data.logo_url);
        $('#btnDeleteLogo').off('click').on('click', function() {
            confirmAction('¿Eliminar el logo de esta marca?').then(function(r) {
                if (r.isConfirmed) {
                    $.ajax({
                        url: '/admin/brands/' + editingId + '/logo',
                        method: 'DELETE',
                        success: function(res) { closeModal(); ajaxSuccess(res.message); },
                        error: handleAjaxError
                    });
                }
            });
        });
    } else {
        $('#currentLogo').addClass('hidden');
    }
    openModal();
}

function saveForm() {
    var formData = new FormData();
    formData.append('name', $('#fName').val());
    formData.append('description', $('#fDescription').val());
    formData.append('is_active', $('#fActive').is(':checked') ? 1 : 0);
    formData.append('show_in_home', $('#fShowInHome').is(':checked') ? 1 : 0);

    var fileInput = document.getElementById('logoFile');
    if (fileInput && fileInput.files[0]) formData.append('logo', fileInput.files[0]);

    if (editingId) formData.append('_method', 'PUT');

    $.ajax({
        url: editingId ? '/admin/brands/' + editingId : '/admin/brands',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) { closeModal(); ajaxSuccess(res.message); },
        error: handleAjaxError
    });
}

function deleteItem(id) {
    confirmAction('¿Estás seguro de que deseas eliminar esta marca?').then(function(r) {
        if (r.isConfirmed) {
            $.ajax({
                url: '/admin/brands/' + id,
                method: 'DELETE',
                success: function(res) { ajaxSuccess(res.message); },
                error: handleAjaxError
            });
        }
    });
}
</script>
@endpush
