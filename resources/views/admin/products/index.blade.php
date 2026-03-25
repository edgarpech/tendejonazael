@extends('layouts.app')

@section('title', 'Productos - Tendejón Azael')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="admin-title text-2xl font-bold text-gray-900 dark:text-white">Productos</h1>
            <p class="admin-subtitle text-sm text-gray-500 dark:text-gray-400">Gestión del catálogo de productos</p>
        </div>
        <button onclick="openForm()" class="btn-add inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo Producto
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
                <form id="productForm" class="space-y-4" onsubmit="return false;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre *</label>
                            <input type="text" id="fName" class="fi" placeholder="Nombre del producto">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">SKU</label>
                            <input type="text" id="fSku" class="fi" placeholder="Código SKU (auto si vacío)">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Categoría *</label>
                            <select id="fCategory" class="fi"></select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Marca</label>
                            <select id="fBrand" class="fi"></select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Precio Costo</label>
                            <input type="number" id="fCostPrice" class="fi" min="0" step="0.01" placeholder="0.00">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Precio Venta *</label>
                            <input type="number" id="fPrice" class="fi" min="0" step="0.01" placeholder="0.00">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                        <textarea id="fDescription" class="fi" rows="3" placeholder="Descripción del producto"></textarea>
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="toggle-switch"><input type="checkbox" id="fActive"><span class="slider"></span></label>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Activo</span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Imagen</label>
                        <div id="currentImage" class="mb-2 hidden flex items-center gap-3">
                            <img id="currentImgPreview" class="w-20 h-20 rounded-lg object-cover" src="">
                            <button type="button" id="btnDeleteImage" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium flex items-center gap-1 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Eliminar imagen
                            </button>
                        </div>
                        <input type="file" id="imageFile" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300">
                        <div id="cropperContainer" class="mt-2 hidden" style="max-height:200px;overflow:hidden;">
                            <img id="cropImage" src="" style="max-width:100%;display:block;">
                        </div>
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

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/cropperjs/cropper.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('vendor/cropperjs/cropper.min.js') }}"></script>
<script>
var productsData = @json($products);
var categoriesData = @json($categories);
var brandsData = @json($brands);
var editingId = null;
var cropper = null;

var catMap = {}, brandMap = {};
categoriesData.forEach(function(c) { catMap[c.id_category] = c.name; });
brandsData.forEach(function(b) { brandMap[b.id_brand] = b.name; });

$(function() {
    var catOpts = '<option value="">Seleccionar categoría</option>';
    categoriesData.forEach(function(c) { catOpts += '<option value="' + c.id_category + '">' + $('<span>').text(c.name).html() + '</option>'; });
    $('#fCategory').html(catOpts);

    var brandOpts = '<option value="">Sin marca</option>';
    brandsData.forEach(function(b) { brandOpts += '<option value="' + b.id_brand + '">' + $('<span>').text(b.name).html() + '</option>'; });
    $('#fBrand').html(brandOpts);

    $('#dataTable').DataTable({
        data: productsData,
        responsive: true,
        language: dtLang,
        pageLength: 10,
        lengthMenu: [10, 15, 25, 50],
        order: [[1, 'asc']],
        columns: [
            {
                data: 'main_image_url', title: 'Foto', width: '50px', orderable: false, searchable: false, responsivePriority: 4,
                render: function(v) {
                    var src = v ? '/storage/' + v : '/images/logos/logo.webp';
                    return '<img src="' + src + '" class="dt-thumb" alt="">';
                }
            },
            { data: 'name', title: 'Nombre', responsivePriority: 1 },
            { data: 'sku', title: 'SKU', defaultContent: '', responsivePriority: 6 },
            {
                data: 'category_id', title: 'Categoría', responsivePriority: 5,
                render: function(v) { return catMap[v] || ''; }
            },
            {
                data: 'brand_id', title: 'Marca', responsivePriority: 6,
                render: function(v) { return brandMap[v] || ''; }
            },
            {
                data: 'price', title: 'Precio', className: 'dt-right', responsivePriority: 2,
                render: function(v) { return '$' + parseFloat(v || 0).toFixed(2); }
            },
            {
                data: 'is_active', title: 'Activo', className: 'dt-center', width: '80px', responsivePriority: 5,
                render: function(v) {
                    var cls = v ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-800/40 dark:text-emerald-300' : 'bg-red-100 text-red-700 dark:bg-red-800/40 dark:text-red-300';
                    return '<span class="px-2 py-1 text-xs rounded-full font-medium ' + cls + '">' + (v ? 'Sí' : 'No') + '</span>';
                }
            },
            {
                data: 'id_product', title: 'Acciones', className: 'dt-center', width: '90px', orderable: false, searchable: false, responsivePriority: 3,
                render: function(id) {
                    return '<div class="flex items-center justify-center gap-1">' +
                        '<button onclick="openForm(' + id + ')" class="p-1.5 text-blue-500 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-800/30 rounded" title="Editar"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>' +
                        '<button onclick="deleteItem(' + id + ')" class="p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-800/30 rounded" title="Eliminar"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>' +
                    '</div>';
                }
            }
        ]
    });

    $('#imageFile').on('change', function(e) {
        var file = e.target.files[0];
        if (!file) return;
        destroyCropper();
        var reader = new FileReader();
        reader.onload = function(ev) {
            $('#cropImage').attr('src', ev.target.result);
            $('#cropperContainer').removeClass('hidden');
            cropper = new Cropper(document.getElementById('cropImage'), {
                aspectRatio: 1, viewMode: 2, autoCropArea: 0.8, responsive: true, guides: true, background: false
            });
        };
        reader.readAsDataURL(file);
    });
});

function openModal() { $('#formModal').removeClass('hidden'); }
function closeModal() { $('#formModal').addClass('hidden'); destroyCropper(); }

function destroyCropper() {
    if (cropper) { cropper.destroy(); cropper = null; }
    $('#cropperContainer').addClass('hidden');
    $('#cropImage').attr('src', '');
}

function openForm(id) {
    editingId = id || null;
    var data = id ? productsData.find(function(p) { return p.id_product === id; }) : {};
    data = data || {};
    $('#modalTitle').text(id ? 'Editar Producto' : 'Nuevo Producto');
    $('#fName').val(data.name || '');
    $('#fSku').val(data.sku || '');
    $('#fCategory').val(data.category_id || '');
    $('#fBrand').val(data.brand_id || '');
    $('#fPrice').val(data.price || '');
    $('#fCostPrice').val(data.cost_price || '');
    $('#fDescription').val(data.description || '');
    $('#fActive').prop('checked', data.is_active !== undefined ? !!data.is_active : true);
    $('#imageFile').val('');
    destroyCropper();

    if (data.main_image_url) {
        $('#currentImage').removeClass('hidden');
        $('#currentImgPreview').attr('src', '/storage/' + data.main_image_url);
        $('#btnDeleteImage').off('click').on('click', function() {
            confirmAction('¿Eliminar la imagen de este producto?').then(function(r) {
                if (r.isConfirmed) {
                    $.ajax({
                        url: '/admin/products/' + editingId + '/image',
                        method: 'DELETE',
                        success: function(res) { closeModal(); ajaxSuccess(res.message); },
                        error: handleAjaxError
                    });
                }
            });
        });
    } else {
        $('#currentImage').addClass('hidden');
    }
    openModal();
}

function saveForm() {
    var formData = new FormData();
    formData.append('name', $('#fName').val());
    formData.append('sku', $('#fSku').val());
    formData.append('category_id', $('#fCategory').val());
    formData.append('brand_id', $('#fBrand').val() || '');
    formData.append('price', $('#fPrice').val() || 0);
    var costPrice = $('#fCostPrice').val();
    if (costPrice) formData.append('cost_price', costPrice);
    formData.append('description', $('#fDescription').val());
    formData.append('is_active', $('#fActive').is(':checked') ? 1 : 0);
    if (editingId) formData.append('_method', 'PUT');

    function submitData(fd) {
        $.ajax({
            url: editingId ? '/admin/products/' + editingId : '/admin/products',
            method: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function(res) { closeModal(); ajaxSuccess(res.message); },
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
        if (fileInput && fileInput.files[0]) formData.append('image', fileInput.files[0]);
        submitData(formData);
    }
}

function deleteItem(id) {
    confirmAction('¿Estás seguro de que deseas eliminar este producto?').then(function(r) {
        if (r.isConfirmed) {
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
