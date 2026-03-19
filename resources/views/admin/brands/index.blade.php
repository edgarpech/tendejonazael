@extends('layouts.app')

@section('title', 'Marcas - Tendejón Azael')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Marcas</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Gestión de marcas de productos</p>
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
var brandsData = @json($brands);
var editingId = null;
var popup = null;

$(function() {
    $('#btnAdd').dxButton({
        text: 'Nueva Marca',
        icon: 'plus',
        type: 'default',
        stylingMode: 'contained',
        onClick: function() { openForm(); }
    });

    $('#dataGrid').dxDataGrid({
        width: '100%',
        dataSource: brandsData,
        keyExpr: 'id_brand',
        showBorders: true,
        showRowLines: true,
        rowAlternationEnabled: true,
        columnAutoWidth: true,
        allowColumnResizing: true,
        columnResizingMode: 'widget',
        sorting: { mode: 'single' },
        searchPanel: { visible: true, placeholder: 'Buscar marca...', width: 300 },
        paging: { pageSize: 10 },
        pager: { showPageSizeSelector: true, allowedPageSizes: [10, 15, 25, 50], showInfo: true },
        columns: [
            {
                dataField: 'logo_url',
                caption: '',
                width: 50,
                allowSorting: false,
                allowFiltering: false,
                cellTemplate: function(container, options) {
                    var src = options.value ? '/storage/' + options.value : '/images/logos/logo.webp';
                    $('<img>').attr('src', src).addClass('w-8 h-8 rounded-lg object-contain').appendTo(container);
                }
            },
            { dataField: 'name', caption: 'Nombre', minWidth: 150, sortOrder: 'asc' },
            { dataField: 'description', caption: 'Descripción', minWidth: 200 },
            { dataField: 'products_count', caption: 'Productos', width: 100, alignment: 'center', dataType: 'number' },
            {
                dataField: 'is_active',
                caption: 'Activo',
                width: 80,
                alignment: 'center',
                cellTemplate: function(container, options) {
                    var cls = options.value ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-800/40 dark:text-emerald-300' : 'bg-red-100 text-red-700 dark:bg-red-800/40 dark:text-red-300';
                    $('<span>').addClass('px-2 py-1 text-xs rounded-full font-medium ' + cls).text(options.value ? 'Sí' : 'No').appendTo(container);
                }
            },
            {
                dataField: 'show_in_home',
                caption: 'Home',
                width: 80,
                alignment: 'center',
                cellTemplate: function(container, options) {
                    var cls = options.value ? 'bg-blue-100 text-blue-700 dark:bg-blue-800/40 dark:text-blue-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-800/40 dark:text-gray-300';
                    $('<span>').addClass('px-2 py-1 text-xs rounded-full font-medium ' + cls).text(options.value ? 'Sí' : 'No').appendTo(container);
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
                        $('<button>').addClass('p-1.5 text-blue-500 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-800/30 rounded').attr('title', 'Editar').html('<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>').on('click', function() { openForm(options.data.id_brand); }),
                        $('<button>').addClass('p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-800/30 rounded').attr('title', 'Eliminar').html('<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>').on('click', function() { deleteItem(options.data.id_brand); })
                    ).appendTo(container);
                }
            }
        ]
    });

    popup = $('#formPopup').dxPopup({
        title: 'Nueva Marca',
        showTitle: true,
        width: Math.min(500, $(window).width() - 40),
        height: 'auto',
        showCloseButton: true,
        visible: false,
        dragEnabled: true,
        shading: true,
        contentTemplate: function(container) {
            container.append(`
                <form id="brandForm" class="space-y-4 p-2" onsubmit="return false;">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre *</label>
                        <div id="fName"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                        <div id="fDescription"></div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div id="fActive"></div>
                        <label class="text-sm text-gray-700 dark:text-gray-300">Activo</label>
                    </div>
                    <div class="flex items-center gap-3">
                        <div id="fShowInHome"></div>
                        <label class="text-sm text-gray-700 dark:text-gray-300">Mostrar en Home</label>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Logo</label>
                        <div id="currentLogo" class="mb-2 hidden">
                            <img id="currentLogoPreview" class="w-16 h-16 rounded-lg object-contain bg-gray-50 dark:bg-gray-700 p-1" src="">
                        </div>
                        <input type="file" id="logoFile" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300">
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
    $('#fName').dxTextBox({ value: data.name || '', placeholder: 'Nombre de la marca' });
    $('#fDescription').dxTextArea({ value: data.description || '', height: 80, placeholder: 'Descripción opcional' });
    $('#fActive').dxSwitch({ value: data.is_active !== undefined ? !!data.is_active : true });
    $('#fShowInHome').dxSwitch({ value: data.show_in_home !== undefined ? !!data.show_in_home : false });
    $('#btnCancel').dxButton({ text: 'Cancelar', stylingMode: 'outlined', onClick: function() { popup.hide(); } });
    $('#btnSave').dxButton({ text: 'Guardar', type: 'default', stylingMode: 'contained', onClick: saveForm });

    if (data.logo_url) {
        $('#currentLogo').removeClass('hidden');
        $('#currentLogoPreview').attr('src', '/storage/' + data.logo_url);
    } else {
        $('#currentLogo').addClass('hidden');
    }
    $('#logoFile').val('');
}

function openForm(id) {
    editingId = id || null;
    popup.option('title', id ? 'Editar Marca' : 'Nueva Marca');
    popup.show();
    setTimeout(function() {
        var data = id ? brandsData.find(function(b) { return b.id_brand === id; }) : {};
        initFormWidgets(data || {});
    }, 100);
}

function saveForm() {
    var formData = new FormData();
    formData.append('name', $('#fName').dxTextBox('instance').option('value') || '');
    formData.append('description', $('#fDescription').dxTextArea('instance').option('value') || '');
    formData.append('is_active', $('#fActive').dxSwitch('instance').option('value') ? 1 : 0);
    formData.append('show_in_home', $('#fShowInHome').dxSwitch('instance').option('value') ? 1 : 0);

    var fileInput = document.getElementById('logoFile');
    if (fileInput && fileInput.files[0]) {
        formData.append('logo', fileInput.files[0]);
    }

    if (editingId) formData.append('_method', 'PUT');

    $.ajax({
        url: editingId ? '/admin/brands/' + editingId : '/admin/brands',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            popup.hide();
            ajaxSuccess(res.message);
        },
        error: handleAjaxError
    });
}

function deleteItem(id) {
    var result = DevExpress.ui.dialog.confirm('¿Estás seguro de que deseas eliminar esta marca?', 'Confirmar eliminación');
    result.done(function(dialogResult) {
        if (dialogResult) {
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
