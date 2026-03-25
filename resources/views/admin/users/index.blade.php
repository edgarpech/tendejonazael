@extends('layouts.app')

@section('title', 'Usuarios - Tendejón Azael')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="admin-title text-2xl font-bold text-gray-900 dark:text-white">Usuarios</h1>
            <p class="admin-subtitle text-sm text-gray-500 dark:text-gray-400">Gestión de usuarios del sistema</p>
        </div>
        <button onclick="openForm()" class="btn-add inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo Usuario
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
                <form id="userForm" class="space-y-4" onsubmit="return false;">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre *</label>
                        <input type="text" id="fName" class="fi" placeholder="Nombre completo">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo Electrónico *</label>
                        <input type="email" id="fEmail" class="fi" placeholder="correo@ejemplo.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rol *</label>
                        <select id="fRole" class="fi"></select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña <span id="pwdReq">*</span></label>
                        <input type="password" id="fPassword" class="fi" placeholder="Mínimo 8 caracteres">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Contraseña</label>
                        <input type="password" id="fPasswordConfirm" class="fi" placeholder="Repetir contraseña">
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
var usersData = @json($users);
var rolesData = @json($roles);
var currentUserId = {{ auth()->id() }};
var editingId = null;

var roleMap = {};
rolesData.forEach(function(r) { roleMap[r.id_role] = r.display_name; });

$(function() {
    var roleOpts = '<option value="">Seleccionar rol</option>';
    rolesData.forEach(function(r) { roleOpts += '<option value="' + r.id_role + '">' + $('<span>').text(r.display_name).html() + '</option>'; });
    $('#fRole').html(roleOpts);

    $('#dataTable').DataTable({
        data: usersData,
        responsive: true,
        language: dtLang,
        pageLength: 10,
        lengthMenu: [10, 15, 25, 50],
        order: [[1, 'asc']],
        columns: [
            {
                data: 'name', title: '', width: '50px', orderable: false, searchable: false, responsivePriority: 10001,
                render: function(v) {
                    var initial = (v || '?').charAt(0).toUpperCase();
                    return '<div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold">' + initial + '</div>';
                }
            },
            { data: 'name', title: 'Nombre' },
            { data: 'email', title: 'Correo' },
            {
                data: 'role_id', title: 'Rol',
                render: function(v) { return roleMap[v] || ''; }
            },
            {
                data: 'is_active', title: 'Estado', className: 'dt-center', width: '100px',
                render: function(v) {
                    var cls = v ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-800/40 dark:text-emerald-300' : 'bg-red-100 text-red-700 dark:bg-red-800/40 dark:text-red-300';
                    return '<span class="px-2 py-1 text-xs rounded-full font-medium ' + cls + '">' + (v ? 'Activo' : 'Inactivo') + '</span>';
                }
            },
            {
                data: 'last_login_at', title: 'Último acceso', responsivePriority: 5,
                render: function(v) {
                    if (!v) return 'Nunca';
                    return new Date(v).toLocaleDateString('es-MX', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                }
            },
            {
                data: null, title: 'Acciones', className: 'dt-center', width: '100px', orderable: false, searchable: false,
                render: function(data) {
                    var html = '<div class="flex items-center justify-center gap-1">';
                    html += '<button onclick="openForm(' + data.id_user + ')" class="p-1.5 text-blue-500 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-800/30 rounded" title="Editar"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>';
                    if (data.id_user !== currentUserId) {
                        html += '<button onclick="deleteItem(' + data.id_user + ')" class="p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-800/30 rounded" title="Eliminar"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>';
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
    var data = id ? usersData.find(function(u) { return u.id_user === id; }) : {};
    data = data || {};
    var isEdit = !!id;
    $('#modalTitle').text(isEdit ? 'Editar Usuario' : 'Nuevo Usuario');
    $('#fName').val(data.name || '');
    $('#fEmail').val(data.email || '');
    $('#fRole').val(data.role_id || '');
    $('#fPassword').val('').attr('placeholder', isEdit ? 'Dejar vacío para no cambiar' : 'Mínimo 8 caracteres');
    $('#fPasswordConfirm').val('');
    $('#fActive').prop('checked', data.is_active !== undefined ? !!data.is_active : true);
    $('#pwdReq').toggle(!isEdit);
    openModal();
}

function saveForm() {
    var formData = {
        name: $('#fName').val(),
        email: $('#fEmail').val(),
        role_id: $('#fRole').val(),
        is_active: $('#fActive').is(':checked') ? 1 : 0
    };
    var password = $('#fPassword').val();
    var passwordConfirm = $('#fPasswordConfirm').val();
    if (password) {
        formData.password = password;
        formData.password_confirmation = passwordConfirm;
    }
    if (editingId) formData._method = 'PUT';

    $.ajax({
        url: editingId ? '/admin/users/' + editingId : '/admin/users',
        method: 'POST',
        data: formData,
        success: function(res) { closeModal(); ajaxSuccess(res.message); },
        error: handleAjaxError
    });
}

function deleteItem(id) {
    confirmAction('¿Estás seguro de que deseas eliminar este usuario?').then(function(r) {
        if (r.isConfirmed) {
            $.ajax({
                url: '/admin/users/' + id,
                method: 'DELETE',
                success: function(res) { ajaxSuccess(res.message); },
                error: handleAjaxError
            });
        }
    });
}
</script>
@endpush
