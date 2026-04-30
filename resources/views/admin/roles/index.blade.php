@extends('layouts.app')

@section('title', 'Roles - Tendejón Azael')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="admin-title text-2xl font-bold text-gray-900 dark:text-white">Roles</h1>
            <p class="admin-subtitle text-sm text-gray-500 dark:text-gray-400">Gestión de roles y permisos</p>
        </div>
        <button onclick="openForm()" class="btn-add inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo Rol
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
        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-lg max-h-[85vh] overflow-y-auto pointer-events-auto">
            <div class="sticky top-0 bg-white dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between z-10">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white"></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 modal-body">
                <form id="roleForm" class="space-y-4" onsubmit="return false;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre Visible *</label>
                            <input type="text" id="fDisplayName" class="fi" placeholder="Ej: Administrador">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Identificador *</label>
                            <input type="text" id="fName" class="fi" placeholder="Ej: admin (sin espacios)">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                        <textarea id="fDescription" class="fi" rows="2" placeholder="Descripción del rol"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nivel *</label>
                        <select id="fLevel" class="fi">
                            <option value="1">1 - Básico</option>
                            <option value="2">2 - Medio</option>
                            <option value="3">3 - Alto</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Permisos</label>
                        <div id="permissionsContainer" class="max-h-48 overflow-y-auto border border-gray-200 dark:border-gray-700 rounded-lg p-3" style="overscroll-behavior:contain;"></div>
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
var rolesData = @json($roles);
var modulesData = @json($modules);
var editingId = null;

var levelColors = {
    3: 'bg-red-100 text-red-700 dark:bg-red-800/40 dark:text-red-300',
    2: 'bg-yellow-100 text-yellow-700 dark:bg-yellow-800/40 dark:text-yellow-300',
    1: 'bg-blue-100 text-blue-700 dark:bg-blue-800/40 dark:text-blue-300'
};
var levelNames = { 3: 'Alto', 2: 'Medio', 1: 'Básico' };

var moduleTranslations = {
    'users': 'Usuarios', 'roles': 'Roles', 'products': 'Productos',
    'categories': 'Categorías', 'brands': 'Marcas', 'security': 'Seguridad',
    'articles': 'Artículos', 'reviews': 'Reseñas'
};
var actionTranslations = {
    'view': 'Ver', 'create': 'Crear', 'edit': 'Editar', 'delete': 'Eliminar',
    'manage': 'Gestionar', 'export': 'Exportar', 'import': 'Importar',
    'quick-photo': 'Foto rápida (escáner)'
};

$(function() {
    var permHtml = '';
    $.each(modulesData, function(mod, perms) {
        var label = moduleTranslations[mod] || mod.charAt(0).toUpperCase() + mod.slice(1);
        permHtml += '<div class="mb-3"><h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">' + label + '</h4><div class="flex flex-wrap gap-2">';
        $.each(perms, function(i, p) {
            var aLabel = actionTranslations[p.action] || p.action;
            permHtml += '<label class="inline-flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400"><input type="checkbox" class="perm-cb rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500" value="' + p.id_permission + '"> ' + aLabel + '</label>';
        });
        permHtml += '</div></div>';
    });
    $('#permissionsContainer').html(permHtml);

    $('#dataTable').DataTable({
        data: rolesData,
        responsive: true,
        language: dtLang,
        pageLength: 10,
        order: [[0, 'asc']],
        columns: [
            { data: 'display_name', title: 'Nombre' },
            { data: 'name', title: 'Identificador', responsivePriority: 5 },
            { data: 'description', title: 'Descripción', defaultContent: '', responsivePriority: 5 },
            {
                data: 'level', title: 'Nivel', className: 'dt-center', width: '90px',
                render: function(v) {
                    var cls = levelColors[v] || levelColors[1];
                    return '<span class="px-2 py-1 text-xs rounded-full font-medium ' + cls + '">' + (levelNames[v] || 'N/A') + '</span>';
                }
            },
            { data: 'users_count', title: 'Usuarios', className: 'dt-center', width: '90px' },
            { data: 'permissions_count', title: 'Permisos', className: 'dt-center', width: '90px' },
            {
                data: null, title: 'Acciones', className: 'dt-center', width: '100px', orderable: false, searchable: false,
                render: function(d) {
                    var html = '<div class="flex items-center justify-center gap-1">';
                    html += '<button onclick="openForm(' + d.id_role + ')" class="p-1.5 text-blue-500 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-800/30 rounded" title="Editar"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>';
                    if (d.name !== 'admin' && d.users_count === 0) {
                        html += '<button onclick="deleteItem(' + d.id_role + ')" class="p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-800/30 rounded" title="Eliminar"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>';
                    }
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
    $('#modalTitle').text(id ? 'Editar Rol' : 'Nuevo Rol');

    if (id) {
        $.getJSON('/admin/roles/' + id + '/edit', function(role) {
            populateForm(role);
        }).fail(function() {
            var data = rolesData.find(function(r) { return r.id_role === id; }) || {};
            populateForm(data);
        });
    } else {
        populateForm({});
    }
    openModal();
}

function populateForm(data) {
    data = data || {};
    $('#fDisplayName').val(data.display_name || '');
    $('#fName').val(data.name || '');
    $('#fDescription').val(data.description || '');
    $('#fLevel').val(data.level || 1);
    $('.perm-cb').prop('checked', false);
    if (data.permissions) {
        $.each(data.permissions, function(i, p) {
            $('.perm-cb[value="' + p.id_permission + '"]').prop('checked', true);
        });
    }
}

function saveForm() {
    var permissions = [];
    $('.perm-cb:checked').each(function() { permissions.push($(this).val()); });

    var formData = {
        display_name: $('#fDisplayName').val(),
        name: $('#fName').val(),
        description: $('#fDescription').val(),
        level: $('#fLevel').val(),
        permissions: permissions
    };
    if (editingId) formData._method = 'PUT';

    $.ajax({
        url: editingId ? '/admin/roles/' + editingId : '/admin/roles',
        method: 'POST',
        data: formData,
        success: function(res) { closeModal(); ajaxSuccess(res.message); },
        error: handleAjaxError
    });
}

function deleteItem(id) {
    confirmAction('¿Estás seguro de que deseas eliminar este rol?').then(function(r) {
        if (r.isConfirmed) {
            $.ajax({
                url: '/admin/roles/' + id,
                method: 'DELETE',
                success: function(res) { ajaxSuccess(res.message); },
                error: handleAjaxError
            });
        }
    });
}
</script>
@endpush
