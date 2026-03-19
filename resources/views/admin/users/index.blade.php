@extends('layouts.app')

@section('title', 'Usuarios - Tendejón Azael')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Usuarios</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Gestión de usuarios del sistema</p>
        </div>
        <div id="btnAdd"></div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4">
        <div id="dataGrid"></div>
    </div>
</div>

<div id="formPopup"></div>
@endsection

@push('scripts')
<script>
var usersData = @json($users);
var rolesData = @json($roles);
var currentUserId = {{ auth()->id() }};
var editingId = null;
var popup = null;

$(function() {
    $('#btnAdd').dxButton({
        text: 'Nuevo Usuario',
        icon: 'plus',
        type: 'default',
        stylingMode: 'contained',
        onClick: function() { openForm(); }
    });

    $('#dataGrid').dxDataGrid({
        dataSource: usersData,
        keyExpr: 'id_user',
        showBorders: true,
        showRowLines: true,
        rowAlternationEnabled: true,
        columnAutoWidth: true,
        sorting: { mode: 'single' },
        searchPanel: { visible: true, placeholder: 'Buscar usuario...', width: 300 },
        paging: { pageSize: 10 },
        pager: { showPageSizeSelector: true, allowedPageSizes: [10, 15, 25, 50], showInfo: true },
        columns: [
            {
                caption: '',
                width: 50,
                allowSorting: false,
                allowFiltering: false,
                cellTemplate: function(container, options) {
                    var initial = (options.data.name || '?').charAt(0).toUpperCase();
                    $('<div>').addClass('w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold').text(initial).appendTo(container);
                }
            },
            { dataField: 'name', caption: 'Nombre', minWidth: 150, sortOrder: 'asc' },
            { dataField: 'email', caption: 'Correo', minWidth: 200 },
            {
                dataField: 'role_id',
                caption: 'Rol',
                lookup: { dataSource: rolesData, valueExpr: 'id_role', displayExpr: 'display_name' }
            },
            {
                dataField: 'is_active',
                caption: 'Estado',
                width: 100,
                alignment: 'center',
                cellTemplate: function(container, options) {
                    var cls = options.value ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                    $('<span>').addClass('px-2 py-1 text-xs rounded-full font-medium ' + cls).text(options.value ? 'Activo' : 'Inactivo').appendTo(container);
                }
            },
            {
                dataField: 'last_login_at',
                caption: 'Último acceso',
                dataType: 'datetime',
                width: 180,
                customizeText: function(e) {
                    if (!e.value) return 'Nunca';
                    return new Date(e.value).toLocaleDateString('es-MX', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                }
            },
            {
                caption: 'Acciones',
                width: 100,
                alignment: 'center',
                allowSorting: false,
                allowFiltering: false,
                cellTemplate: function(container, options) {
                    $('<div>').addClass('flex items-center justify-center gap-1').append(
                        $('<button>').addClass('p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded').attr('title', 'Editar').html('<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>').on('click', function() { openForm(options.data.id_user); }),
                        options.data.id_user !== currentUserId
                            ? $('<button>').addClass('p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded').attr('title', 'Eliminar').html('<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>').on('click', function() { deleteItem(options.data.id_user); })
                            : ''
                    ).appendTo(container);
                }
            }
        ]
    });

    popup = $('#formPopup').dxPopup({
        title: 'Nuevo Usuario',
        showTitle: true,
        width: function() { return Math.min(550, $(window).width() - 40); },
        height: 'auto',
        showCloseButton: true,
        visible: false,
        dragEnabled: true,
        shading: true,
        contentTemplate: function(container) {
            container.append(`
                <form id="userForm" class="space-y-4 p-2" onsubmit="return false;">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre *</label>
                        <div id="fName"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo Electrónico *</label>
                        <div id="fEmail"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rol *</label>
                        <div id="fRole"></div>
                    </div>
                    <div id="passwordSection">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña <span id="pwdReq">*</span></label>
                        <div id="fPassword"></div>
                    </div>
                    <div id="passwordConfirmSection">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Contraseña</label>
                        <div id="fPasswordConfirm"></div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div id="fActive"></div>
                        <label class="text-sm text-gray-700 dark:text-gray-300">Activo</label>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div id="btnCancel"></div>
                        <div id="btnSave"></div>
                    </div>
                </form>
            `);
        }
    }).dxPopup('instance');
});

function initFormWidgets(data) {
    data = data || {};
    var isEdit = !!editingId;

    $('#fName').dxTextBox({ value: data.name || '', placeholder: 'Nombre completo' });
    $('#fEmail').dxTextBox({ value: data.email || '', placeholder: 'correo@ejemplo.com', mode: 'email' });
    $('#fRole').dxSelectBox({
        dataSource: rolesData,
        displayExpr: 'display_name',
        valueExpr: 'id',
        value: data.role_id || null,
        placeholder: 'Seleccionar rol'
    });
    $('#fPassword').dxTextBox({ value: '', placeholder: isEdit ? 'Dejar vacío para no cambiar' : 'Mínimo 8 caracteres', mode: 'password' });
    $('#fPasswordConfirm').dxTextBox({ value: '', placeholder: 'Repetir contraseña', mode: 'password' });
    $('#fActive').dxSwitch({ value: data.is_active !== undefined ? !!data.is_active : true });
    $('#btnCancel').dxButton({ text: 'Cancelar', stylingMode: 'outlined', onClick: function() { popup.hide(); } });
    $('#btnSave').dxButton({ text: 'Guardar', type: 'default', stylingMode: 'contained', onClick: saveForm });

    $('#pwdReq').toggle(!isEdit);
}

function openForm(id) {
    editingId = id || null;
    popup.option('title', id ? 'Editar Usuario' : 'Nuevo Usuario');
    popup.show();
    setTimeout(function() {
        var data = id ? usersData.find(function(u) { return u.id_user === id; }) : {};
        initFormWidgets(data || {});
    }, 100);
}

function saveForm() {
    var formData = {
        name: $('#fName').dxTextBox('instance').option('value'),
        email: $('#fEmail').dxTextBox('instance').option('value'),
        role_id: $('#fRole').dxSelectBox('instance').option('value'),
        is_active: $('#fActive').dxSwitch('instance').option('value') ? 1 : 0
    };

    var password = $('#fPassword').dxTextBox('instance').option('value');
    var passwordConfirm = $('#fPasswordConfirm').dxTextBox('instance').option('value');

    if (password) {
        formData.password = password;
        formData.password_confirmation = passwordConfirm;
    }

    if (editingId) formData._method = 'PUT';

    $.ajax({
        url: editingId ? '/admin/users/' + editingId : '/admin/users',
        method: 'POST',
        data: formData,
        success: function(res) {
            popup.hide();
            ajaxSuccess(res.message);
        },
        error: handleAjaxError
    });
}

function deleteItem(id) {
    var result = DevExpress.ui.dialog.confirm('¿Estás seguro de que deseas eliminar este usuario?', 'Confirmar eliminación');
    result.done(function(dialogResult) {
        if (dialogResult) {
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
