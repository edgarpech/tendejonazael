@extends('layouts.app')

@section('title', 'Productos - Tendejón Azael')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Productos</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Gestión del catálogo de productos</p>
        </div>
        <div id="btnAdd"></div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4">
        <div id="dataGrid"></div>
    </div>
</div>

<div id="formPopup"></div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/cropperjs/cropper.min.css') }}">
<style>
    #cropperContainer { max-height: 200px; overflow: hidden; }
    #cropperContainer img { max-width: 100%; display: block; }
</style>
@endpush

@push('scripts')
<script src="{{ asset('vendor/cropperjs/cropper.min.js') }}"></script>
<script>
var productsData = @json($products);
var categoriesData = @json($categories);
var brandsData = @json($brands);
var editingId = null;
var cropper = null;
var popup = null;

$(function() {
    $('#btnAdd').dxButton({
        text: 'Nuevo Producto',
        icon: 'plus',
        type: 'default',
        stylingMode: 'contained',
        onClick: function() { openForm(); }
    });

    $('#dataGrid').dxDataGrid({
        width: '100%',
        dataSource: productsData,
        keyExpr: 'id_product',
        showBorders: true,
        showRowLines: true,
        rowAlternationEnabled: true,
        columnAutoWidth: true,
        allowColumnResizing: true,
        columnResizingMode: 'widget',
        wordWrapEnabled: true,
        searchPanel: { visible: true, placeholder: 'Buscar producto...', width: 300 },
        filterRow: { visible: false },
        paging: { pageSize: 10 },
        pager: { showPageSizeSelector: true, allowedPageSizes: [10, 15, 25, 50], showInfo: true },
        columns: [
            {
                dataField: 'main_image_url',
                caption: '',
                width: 50,
                allowSorting: false,
                allowFiltering: false,
                cellTemplate: function(container, options) {
                    var src = options.value ? '/storage/' + options.value : '/images/logos/logo.webp';
                    $('<img>').attr('src', src).addClass('w-8 h-8 rounded-lg object-cover').appendTo(container);
                }
            },
            { dataField: 'name', caption: 'Nombre', minWidth: 120, sortOrder: 'asc' },
            { dataField: 'sku', caption: 'SKU', width: 110 },
            {
                dataField: 'category_id',
                caption: 'Categoría',
                width: 150,
                lookup: { dataSource: categoriesData, valueExpr: 'id_category', displayExpr: 'name' }
            },
            {
                dataField: 'brand_id',
                caption: 'Marca',
                width: 150,
                lookup: { dataSource: brandsData, valueExpr: 'id_brand', displayExpr: 'name' }
            },
            {
                dataField: 'price',
                caption: 'Precio Venta',
                dataType: 'number',
                width: 110,
                customizeText: function(e) { return '$' + parseFloat(e.value || 0).toFixed(2); }
            },
            {
                dataField: 'is_active',
                caption: 'Activo',
                width: 100,
                alignment: 'center',
                cellTemplate: function(container, options) {
                    var cls = options.value ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-800/40 dark:text-emerald-300' : 'bg-red-100 text-red-700 dark:bg-red-800/40 dark:text-red-300';
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
                        $('<button>').addClass('p-1.5 text-blue-500 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-800/30 rounded').html('<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>').on('click', function() { openForm(options.data.id_product); }),
                        $('<button>').addClass('p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-800/30 rounded').html('<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>').on('click', function() { deleteItem(options.data.id_product); })
                    ).appendTo(container);
                }
            }
        ]
    });

    popup = $('#formPopup').dxPopup({
        title: 'Nuevo Producto',
        showTitle: true,
        width: Math.min(900, $(window).width() - 40),
        height: Math.min($(window).height() * 0.85, 700),
        showCloseButton: true,
        visible: false,
        dragEnabled: true,
        shading: true,
        contentTemplate: function(container) {
            container.append(getFormHtml());
        },
        onHidden: function() { destroyCropper(); }
    }).dxPopup('instance');
});

function getFormHtml() {
    return `
        <form id="productForm" class="space-y-4 p-2" onsubmit="return false;">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre *</label>
                    <div id="fName"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">SKU</label>
                    <div id="fSku"></div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Categoría *</label>
                    <div id="fCategory"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Marca</label>
                    <div id="fBrand"></div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Precio Costo</label>
                    <div id="fCostPrice"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Precio Venta *</label>
                    <div id="fPrice"></div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                <div id="fDescription"></div>
            </div>
            <div class="flex items-center gap-3">
                <div id="fActive"></div>
                <label class="text-sm text-gray-700 dark:text-gray-300">Activo</label>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Imagen</label>
                <div id="currentImage" class="mb-2 hidden">
                    <img id="currentImgPreview" class="w-20 h-20 rounded-lg object-cover" src="">
                </div>
                <input type="file" id="imageFile" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300">
                <div id="cropperContainer" class="mt-2 hidden">
                    <img id="cropImage" src="">
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div id="btnCancel"></div>
                <div id="btnSave"></div>
            </div>
        </form>
    `;
}

function initFormWidgets(data) {
    data = data || {};

    $('#fName').dxTextBox({ value: data.name || '', placeholder: 'Nombre del producto' });
    $('#fSku').dxTextBox({ value: data.sku || '', placeholder: 'Código SKU (auto si vacío)' });
    $('#fCategory').dxSelectBox({
        dataSource: categoriesData,
        displayExpr: 'name',
        valueExpr: 'id_category',
        value: data.category_id || null,
        placeholder: 'Seleccionar categoría',
        searchEnabled: true,
        dropDownOptions: { container: 'body' }
    });
    $('#fBrand').dxSelectBox({
        dataSource: brandsData,
        displayExpr: 'name',
        valueExpr: 'id_brand',
        value: data.brand_id || null,
        placeholder: 'Seleccionar marca',
        searchEnabled: true,
        showClearButton: true,
        dropDownOptions: { container: 'body' }
    });
    $('#fPrice').dxNumberBox({ value: parseFloat(data.price) || 0, min: 0, format: '#,##0.00', placeholder: '0.00' });
    $('#fCostPrice').dxNumberBox({ value: parseFloat(data.cost_price) || null, min: 0, format: '#,##0.00', placeholder: '0.00' });
    $('#fDescription').dxTextArea({ value: data.description || '', height: 80, placeholder: 'Descripción del producto' });
    $('#fActive').dxSwitch({ value: data.is_active !== undefined ? !!data.is_active : true });

    $('#btnCancel').dxButton({ text: 'Cancelar', stylingMode: 'outlined', onClick: function() { popup.hide(); } });
    $('#btnSave').dxButton({ text: 'Guardar', type: 'default', stylingMode: 'contained', onClick: saveForm });

    if (data.main_image_url) {
        $('#currentImage').removeClass('hidden');
        $('#currentImgPreview').attr('src', '/storage/' + data.main_image_url);
    } else {
        $('#currentImage').addClass('hidden');
    }

    $('#imageFile').off('change').on('change', function(e) {
        var file = e.target.files[0];
        if (!file) return;
        destroyCropper();
        var reader = new FileReader();
        reader.onload = function(ev) {
            $('#cropImage').attr('src', ev.target.result);
            $('#cropperContainer').removeClass('hidden');
            cropper = new Cropper(document.getElementById('cropImage'), {
                aspectRatio: 1,
                viewMode: 2,
                autoCropArea: 0.8,
                responsive: true,
                guides: true,
                background: false
            });
        };
        reader.readAsDataURL(file);
    });
}

function destroyCropper() {
    if (cropper) { cropper.destroy(); cropper = null; }
    $('#cropperContainer').addClass('hidden');
    $('#cropImage').attr('src', '');
}

function openForm(id) {
    editingId = id || null;
    popup.option('title', id ? 'Editar Producto' : 'Nuevo Producto');
    popup.show();

    setTimeout(function() {
        var data = id ? productsData.find(function(p) { return p.id_product === id; }) : {};
        initFormWidgets(data || {});
    }, 100);
}

function saveForm() {
    var formData = new FormData();
    formData.append('name', $('#fName').dxTextBox('instance').option('value') || '');
    formData.append('sku', $('#fSku').dxTextBox('instance').option('value') || '');
    formData.append('category_id', $('#fCategory').dxSelectBox('instance').option('value') || '');
    formData.append('brand_id', $('#fBrand').dxSelectBox('instance').option('value') || '');
    formData.append('price', $('#fPrice').dxNumberBox('instance').option('value') || 0);
    var costPrice = $('#fCostPrice').dxNumberBox('instance').option('value');
    if (costPrice) formData.append('cost_price', costPrice);
    formData.append('description', $('#fDescription').dxTextArea('instance').option('value') || '');
    formData.append('is_active', $('#fActive').dxSwitch('instance').option('value') ? 1 : 0);

    if (editingId) formData.append('_method', 'PUT');

    function submitData(fd) {
        $.ajax({
            url: editingId ? '/admin/products/' + editingId : '/admin/products',
            method: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function(res) {
                popup.hide();
                ajaxSuccess(res.message);
            },
            error: handleAjaxError
        });
    }

    if (cropper) {
        cropper.getCroppedCanvas({ width: 800, height: 800, imageSmoothingQuality: 'high' }).toBlob(function(blob) {
            formData.append('image', blob, 'product.jpg');
            submitData(formData);
        }, 'image/jpeg', 0.85);
    } else {
        var fileInput = document.getElementById('imageFile');
        if (fileInput && fileInput.files[0] && !cropper) {
            formData.append('image', fileInput.files[0]);
        }
        submitData(formData);
    }
}

function deleteItem(id) {
    var result = DevExpress.ui.dialog.confirm('¿Estás seguro de que deseas eliminar este producto?', 'Confirmar eliminación');
    result.done(function(dialogResult) {
        if (dialogResult) {
            $.ajax({
                url: '/admin/products/' + id,
                method: 'DELETE',
                success: function(res) { ajaxSuccess(res.message); },
                error: handleAjaxError
            });
        }
    });
}
</script>
@endpush
