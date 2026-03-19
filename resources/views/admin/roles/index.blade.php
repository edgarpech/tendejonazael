@extends('layouts.app')

@section('title', 'Roles - Tendejón Azael')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Roles</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Gestión de roles y permisos</p>
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
var rolesData = @json($roles);
var modulesData = @json($modules);
var editingId = null;
var popup = null;

$(function() {
    $('#btnAdd').dxButton({
        text: 'Nuevo Rol',
        icon: 'plus',
        type: 'default',
        stylingMode: 'contained',
        onClick: function() { openForm(); }
    });

    var levelColors = {
        3: 'bg-red-100 text-red-700 dark:bg-red-800/40 dark:text-red-300',
        2: 'bg-yellow-100 text-yellow-700 dark:bg-yellow-800/40 dark:text-yellow-300',
        1: 'bg-blue-100 text-blue-700 dark:bg-blue-800/40 dark:text-blue-300'
    };
    var levelNames = { 3: 'Alto', 2: 'Medio', 1: 'Básico' };

    $('#dataGrid').dxDataGrid({
        width: '100%',
        dataSource: rolesData,
        keyExpr: 'id_role',
        showBorders: true,
        showRowLines: true,
        rowAlternationEnabled: true,
        columnAutoWidth: true,
        allowColumnResizing: true,
        columnResizingMode: 'widget',
        sorting: { mode: 'single' },
        searchPanel: { visible: true, placeholder: 'Buscar rol...', width: 300 },
        paging: { pageSize: 10 },
        columns: [
            { dataField: 'display_name', caption: 'Nombre', minWidth: 150, sortOrder: 'asc' },
            { dataField: 'name', caption: 'Identificador', width: 130 },
            { dataField: 'description', caption: 'Descripción', minWidth: 200 },
            {
                dataField: 'level',
                caption: 'Nivel',
                width: 90,
                alignment: 'center',
                cellTemplate: function(container, options) {
                    var cls = levelColors[options.value] || levelColors[1];
                    $('<span>').addClass('px-2 py-1 text-xs rounded-full font-medium ' + cls).text(levelNames[options.value] || 'N/A').appendTo(container);
                }
            },
            { dataField: 'users_count', caption: 'Usuarios', width: 90, alignment: 'center', dataType: 'number' },
            { dataField: 'permissions_count', caption: 'Permisos', width: 90, alignment: 'center', dataType: 'number' },
            {
                caption: 'Acciones',
                width: 100,
                alignment: 'center',
                allowSorting: false,
                allowFiltering: false,
                cellTemplate: function(container, options) {
                    var d = options.data;
                    $('<div>').addClass('flex items-center justify-center gap-1').append(
                        $('<button>').addClass('p-1.5 text-blue-500 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-800/30 rounded').attr('title', 'Editar').html('<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>').on('click', function() { openForm(d.id_role); }),
                        (d.name !== 'admin' && d.users_count === 0)
                            ? $('<button>').addClass('p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-800/30 rounded').attr('title', 'Eliminar').html('<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>').on('click', function() { deleteItem(d.id_role); })
                            : ''
                    ).appendTo(container);
                }
            }
        ]
    });

    popup = $('#formPopup').dxPopup({
        title: 'Nuevo Rol',
        showTitle: true,
        width: Math.min(650, $(window).width() - 40),
        height: 'auto',
        maxHeight: '90vh',
        showCloseButton: true,
        visible: false,
        dragEnabled: true,
        shading: true,
        contentTemplate: function(container) {
            var moduleTranslations = {
                'users': 'Usuarios', 'roles': 'Roles', 'products': 'Productos',
                'categories': 'Categor\u00edas', 'brands': 'Marcas', 'gallery': 'Galer\u00eda',
                'configurations': 'Configuraciones', 'security': 'Seguridad'
            };
            var actionTranslations = {
                'view': 'Ver', 'create': 'Crear', 'edit': 'Editar', 'delete': 'Eliminar',
                'manage': 'Gestionar', 'export': 'Exportar', 'import': 'Importar'
            };
            var permissionsHtml = '';
            $.each(modulesData, function(moduleName, perms) {
                var label = moduleTranslations[moduleName] || moduleName.charAt(0).toUpperCase() + moduleName.slice(1);
                permissionsHtml += '<div class="mb-3"><h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">' + label + '</h4><div class="flex flex-wrap gap-2">';
                $.each(perms, function(i, p) {
                    var actionLabel = actionTranslations[p.action] || p.action;
                    permissionsHtml += '<label class="inline-flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400"><input type="checkbox" class="perm-cb rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500" value="' + p.id_permission + '"> ' + actionLabel + '</label>';
                });
                permissionsHtml += '</div></div>';
            });

            container.append(`
                <form id="roleForm" class="space-y-4 p-2" onsubmit="return false;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre Visible *</label>
                            <div id="fDisplayName"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Identificador *</label>
                            <div id="fName"></div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                        <div id="fDescription"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nivel *</label>
                        <div id="fLevel"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Permisos</label>
                        <div class="max-h-48 overflow-y-auto border border-gray-200 dark:border-gray-700 rounded-lg p-3" style="overscroll-behavior: contain;">
                            ${permissionsHtml}
                        </div>
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
    $('#fDisplayName').dxTextBox({ value: data.display_name || '', placeholder: 'Ej: Administrador' });
    $('#fName').dxTextBox({ value: data.name || '', placeholder: 'Ej: admin (sin espacios)' });
    $('#fDescription').dxTextArea({ value: data.description || '', height: 60, placeholder: 'Descripción del rol' });
    $('#fLevel').dxSelectBox({
        dataSource: [{ id: 1, text: '1 - Básico' }, { id: 2, text: '2 - Medio' }, { id: 3, text: '3 - Alto' }],
        displayExpr: 'text',
        valueExpr: 'id',
        value: data.level || 1,
        placeholder: 'Seleccionar nivel',
        dropDownOptions: { container: 'body' }
    });
    $('#btnCancel').dxButton({ text: 'Cancelar', stylingMode: 'outlined', onClick: function() { popup.hide(); } });
    $('#btnSave').dxButton({ text: 'Guardar', type: 'default', stylingMode: 'contained', onClick: saveForm });

    // Load current permissions if editing
    $('.perm-cb').prop('checked', false);
    if (data.permissions) {
        $.each(data.permissions, function(i, p) {
            $('.perm-cb[value="' + p.id_permission + '"]').prop('checked', true);
        });
    }
}

function openForm(id) {
    editingId = id || null;
    popup.option('title', id ? 'Editar Rol' : 'Nuevo Rol');
    popup.show();
    setTimeout(function() {
        if (id) {
            // Fetch fresh role data with permissions
            $.getJSON('/admin/roles/' + id + '/edit', function(role) {
                // The controller doesn't have a JSON edit endpoint,
                // so we use what we have + fetch permissions from the role data
                var roleData = rolesData.find(function(r) { return r.id_role === id; }) || {};
                // We'll load permissions via a separate approach
                initFormWidgets(roleData);
            }).fail(function() {
                var roleData = rolesData.find(function(r) { return r.id_role === id; }) || {};
                initFormWidgets(roleData);
            });
        } else {
            initFormWidgets({});
        }
    }, 100);
}

function saveForm() {
    var permissions = [];
    $('.perm-cb:checked').each(function() { permissions.push($(this).val()); });

    var formData = {
        display_name: $('#fDisplayName').dxTextBox('instance').option('value'),
        name: $('#fName').dxTextBox('instance').option('value'),
        description: $('#fDescription').dxTextArea('instance').option('value'),
        level: $('#fLevel').dxSelectBox('instance').option('value'),
        permissions: permissions
    };

    if (editingId) formData._method = 'PUT';

    $.ajax({
        url: editingId ? '/admin/roles/' + editingId : '/admin/roles',
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
    var result = DevExpress.ui.dialog.confirm('¿Estás seguro de que deseas eliminar este rol?', 'Confirmar eliminación');
    result.done(function(dialogResult) {
        if (dialogResult) {
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
