@extends('layouts.app')

@section('title', 'Foto Rápida - Tendejón Azael')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="admin-title text-2xl font-bold text-gray-900 dark:text-white">Foto Rápida</h1>
            <p class="admin-subtitle text-sm text-gray-500 dark:text-gray-400">Escanea el código de barras y sube la imagen del producto en segundos.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline whitespace-nowrap">← Productos</a>
    </div>

    {{-- Buscador / Escáner --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-4">
        <div class="flex flex-col sm:flex-row gap-2">
            <div class="relative flex-1">
                <input type="text" id="skuInput" inputmode="numeric" autocomplete="off"
                       placeholder="Escanea o escribe el código (SKU)"
                       class="fi pr-10 text-base">
                <button id="btnClear" type="button"
                        class="hidden absolute inset-y-0 right-2 my-auto h-7 w-7 items-center justify-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                        style="display:none;"
                        title="Limpiar">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <button id="btnLookup" type="button"
                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition flex items-center justify-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Buscar
            </button>
            <button id="btnScan" type="button"
                    class="px-4 py-2 bg-cyan-600 text-white text-sm font-medium rounded-lg hover:bg-cyan-700 transition flex items-center justify-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h2v16H4V4zm3 0h1v16H7V4zm2 0h2v16H9V4zm3 0h1v16h-1V4zm2 0h2v16h-2V4zm3 0h1v16h-1V4zm2 0h2v16h-2V4z"/>
                </svg>
                Escanear
            </button>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
            <i class="fas fa-info-circle"></i>
            Tip: con un lector USB el código aparece automáticamente. En móvil/tablet usa el botón <strong>Escanear</strong>.
        </p>
    </div>

    {{-- Producto encontrado --}}
    <div id="productCard" class="hidden bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-4">
        <div class="flex gap-4 items-start">
            <div class="w-24 h-24 sm:w-32 sm:h-32 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                <img id="pImage" src="" alt="" class="w-full h-full object-cover hidden">
                <svg id="pNoImage" class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div class="min-w-0 flex-1">
                <h2 id="pName" class="text-lg font-semibold text-gray-900 dark:text-white truncate"></h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">SKU: <span id="pSku" class="font-mono"></span></p>
                <p class="text-sm text-gray-500 dark:text-gray-400"><span id="pCategory"></span><span id="pBrandWrap"> · <span id="pBrand"></span></span></p>
                <p class="text-base font-bold text-cyan-700 dark:text-cyan-400 mt-1">$<span id="pPrice"></span> MXN</p>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-2">
            <button type="button" onclick="document.getElementById('cameraInput').click()"
                    class="px-4 py-3 bg-cyan-600 text-white text-sm font-semibold rounded-lg hover:bg-cyan-700 transition flex items-center justify-center gap-2 cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Tomar Foto
            </button>
            <button type="button" onclick="document.getElementById('fileInput').click()"
                    class="px-4 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition flex items-center justify-center gap-2 cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Elegir de la galería
            </button>
        </div>

        <input type="file" id="cameraInput" accept="image/*" capture="environment" class="hidden">
        <input type="file" id="fileInput" accept="image/*" class="hidden">

        {{-- Cropper --}}
        <div id="cropperWrap" class="mt-4 hidden">
            <div id="cropperBox" class="relative bg-gray-100 dark:bg-gray-900 rounded-lg overflow-hidden mx-auto" style="width:100%;max-width:480px;height:60vh;max-height:480px;">
                <img id="cropImage" src="" alt="" style="display:block;max-width:100%;">
            </div>
            <div class="mt-3 flex gap-2">
                <button type="button" id="btnCancelImage"
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Cancelar
                </button>
                <button type="button" id="btnSaveImage"
                        class="flex-1 px-4 py-2 text-sm font-semibold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Guardar
                </button>
            </div>
        </div>
    </div>

    {{-- Estado vacío --}}
    <div id="emptyState" class="bg-white/50 dark:bg-gray-800/50 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-6 text-center text-sm text-gray-500 dark:text-gray-400">
        <svg class="w-10 h-10 mx-auto mb-2 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h2v16H4V4zm3 0h1v16H7V4zm2 0h2v16H9V4zm3 0h1v16h-1V4zm2 0h2v16h-2V4zm3 0h1v16h-1V4zm2 0h2v16h-2V4z"/></svg>
        Escanea o ingresa un SKU para comenzar.
    </div>
</div>

{{-- Modal Escáner --}}
<div id="scannerModal" class="fixed inset-0 z-[80] hidden">
    <div class="fixed inset-0 bg-black/80"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4 pointer-events-none">
        <div class="relative bg-gray-900 rounded-xl shadow-2xl w-full max-w-lg pointer-events-auto overflow-hidden">
            <div class="px-4 py-3 flex items-center justify-between border-b border-gray-700">
                <h3 class="text-base font-semibold text-white">Escanear código</h3>
                <button id="btnCloseScanner" class="text-gray-300 hover:text-white p-1">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="relative bg-black" style="aspect-ratio: 4 / 3;">
                <video id="scannerVideo" class="w-full h-full object-cover" muted playsinline autoplay></video>
                {{-- Overlay guide --}}
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="border-2 border-cyan-400/80 rounded-lg" style="width:75%;height:35%;box-shadow:0 0 0 9999px rgba(0,0,0,0.35);"></div>
                </div>
            </div>
            <div class="px-4 py-3 flex items-center justify-between gap-2">
                <p id="scannerStatus" class="text-xs text-gray-300 flex-1 truncate">Apunta al código de barras…</p>
                <button id="btnSwitchCamera" class="text-xs px-3 py-1.5 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition">
                    Cambiar cámara
                </button>
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
<script src="{{ asset('vendor/zxing/zxing-browser.min.js') }}"></script>
<script>
(function() {
    var currentProduct = null;
    var cropper = null;
    var codeReader = null;
    var availableDevices = [];
    var currentDeviceIdx = 0;
    var lastScannedCode = '';
    var lastScannedAt = 0;

    var $skuInput = $('#skuInput');
    var $btnClear = $('#btnClear');

    $skuInput.on('input', function() {
        if (this.value.length) $btnClear.show(); else $btnClear.hide();
    });
    $btnClear.on('click', function() {
        $skuInput.val('').focus();
        $btnClear.hide();
    });
    $skuInput.on('keydown', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); lookupSku(); }
    });
    $('#btnLookup').on('click', lookupSku);
    $('#btnScan').on('click', openScanner);
    $('#btnCloseScanner').on('click', closeScanner);
    $('#btnSwitchCamera').on('click', switchCamera);

    $('#cameraInput, #fileInput').on('change', function(e) {
        var f = e.target.files && e.target.files[0];
        $(this).val('');
        if (f) loadImageToCropper(f);
    });
    $('#btnCancelImage').on('click', destroyCropper);
    $('#btnSaveImage').on('click', saveImage);

    function lookupSku() {
        var sku = $skuInput.val().trim();
        if (!sku) { showToast('Ingresa un SKU', 'warning'); $skuInput.focus(); return; }
        $.ajax({
            url: '{{ route('admin.products.find-by-sku') }}',
            method: 'GET',
            data: { sku: sku },
            success: function(res) {
                if (res.success) showProduct(res.data);
            },
            error: function(xhr) {
                if (xhr.status === 404) {
                    showToast('No se encontró un producto con ese SKU', 'error');
                    $('#productCard').addClass('hidden');
                    $('#emptyState').removeClass('hidden');
                    currentProduct = null;
                } else {
                    handleAjaxError(xhr);
                }
            }
        });
    }

    function showProduct(p) {
        currentProduct = p;
        $('#pName').text(p.name || '');
        $('#pSku').text(p.sku || '');
        $('#pCategory').text(p.category || 'Sin categoría');
        if (p.brand) {
            $('#pBrand').text(p.brand);
            $('#pBrandWrap').show();
        } else {
            $('#pBrandWrap').hide();
        }
        $('#pPrice').text(parseFloat(p.price || 0).toFixed(2));
        if (p.main_image_url) {
            $('#pImage').attr('src', p.main_image_url + '?t=' + Date.now()).removeClass('hidden');
            $('#pNoImage').addClass('hidden');
        } else {
            $('#pImage').addClass('hidden').attr('src', '');
            $('#pNoImage').removeClass('hidden');
        }
        $('#emptyState').addClass('hidden');
        $('#productCard').removeClass('hidden');
        destroyCropper();
    }

    function loadImageToCropper(file) {
        if (!currentProduct) { showToast('Primero selecciona un producto', 'warning'); return; }
        destroyCropper();
        var reader = new FileReader();
        reader.onload = function(ev) {
            var img = document.getElementById('cropImage');
            img.onload = function() {
                cropper = new Cropper(img, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 0.9,
                    responsive: true,
                    guides: true,
                    background: false,
                    dragMode: 'move',
                    minContainerWidth: 200,
                    minContainerHeight: 200,
                });
            };
            img.src = ev.target.result;
            $('#cropperWrap').removeClass('hidden');
        };
        reader.readAsDataURL(file);
    }

    function destroyCropper() {
        if (cropper) { cropper.destroy(); cropper = null; }
        $('#cropperWrap').addClass('hidden');
        $('#cropImage').attr('src', '');
    }

    function saveImage() {
        if (!cropper || !currentProduct) return;
        var $btn = $('#btnSaveImage');
        $btn.prop('disabled', true).html('<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg> Guardando...');
        cropper.getCroppedCanvas({ width: 800, height: 800, imageSmoothingQuality: 'high' }).toBlob(function(blob) {
            var fd = new FormData();
            fd.append('image', blob, 'product.jpg');
            $.ajax({
                url: '/admin/products/' + currentProduct.id_product + '/image',
                method: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    showToast(res.message || 'Imagen actualizada', 'success');
                    if (res.data && res.data.main_image_url) {
                        currentProduct.main_image_url = res.data.main_image_url;
                        $('#pImage').attr('src', res.data.main_image_url + '?t=' + Date.now()).removeClass('hidden');
                        $('#pNoImage').addClass('hidden');
                    }
                    destroyCropper();
                    // Listo para el siguiente producto
                    $skuInput.val('').focus();
                    $btnClear.hide();
                },
                error: handleAjaxError,
                complete: function() {
                    $btn.prop('disabled', false).html('<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Guardar');
                }
            });
        }, 'image/jpeg', 0.9);
    }

    // ------- Escáner ZXing -------
    function openScanner() {
        if (!window.ZXingBrowser) {
            showToast('Escáner no disponible', 'error');
            return;
        }
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            showToast('Tu navegador no soporta cámara', 'error');
            return;
        }
        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
            showToast('La cámara requiere HTTPS', 'error');
            return;
        }
        $('#scannerModal').removeClass('hidden');
        $('#scannerStatus').text('Solicitando permiso de cámara…');

        // Pedir permiso primero: en móvil, sin permiso, enumerateDevices no devuelve labels
        // ni siempre detecta la cámara trasera correctamente.
        navigator.mediaDevices.getUserMedia({
            video: { facingMode: { ideal: 'environment' } },
            audio: false,
        }).then(function(stream) {
            // Detener el stream de prueba; el lector abrirá el suyo
            stream.getTracks().forEach(function(t) { t.stop(); });
            return ZXingBrowser.BrowserMultiFormatReader.listVideoInputDevices();
        }).then(function(devices) {
            availableDevices = devices || [];
            currentDeviceIdx = 0;
            for (var i = 0; i < availableDevices.length; i++) {
                if (/back|rear|environment|trasera|principal/i.test(availableDevices[i].label || '')) {
                    currentDeviceIdx = i;
                    break;
                }
            }
            startDecoding();
        }).catch(function(err) {
            handleCameraError(err);
        });
    }

    function handleCameraError(err) {
        var name = err && err.name;
        if (name === 'NotAllowedError' || name === 'SecurityError') {
            $('#scannerStatus').text('Permiso denegado. Habilítalo en los ajustes del navegador.');
            showToast('Permiso de cámara denegado', 'error');
        } else if (name === 'NotFoundError' || name === 'OverconstrainedError') {
            $('#scannerStatus').text('No se encontró ninguna cámara compatible');
        } else if (name === 'NotReadableError') {
            $('#scannerStatus').text('La cámara está siendo usada por otra app');
        } else {
            $('#scannerStatus').text('Error: ' + (err && (err.message || err.name) || err));
        }
    }

    function startDecoding() {
        stopDecoding();
        codeReader = new ZXingBrowser.BrowserMultiFormatReader(undefined, {
            delayBetweenScanAttempts: 120,
        });
        var videoEl = document.getElementById('scannerVideo');
        var deviceId = (availableDevices[currentDeviceIdx] || {}).deviceId || null;

        var decodePromise;
        if (deviceId) {
            decodePromise = codeReader.decodeFromVideoDevice(deviceId, videoEl, onDecodeCallback);
        } else {
            // Algunos móviles no enumeran bien: usar constraints con facingMode
            decodePromise = codeReader.decodeFromConstraints({
                video: {
                    facingMode: { ideal: 'environment' },
                    width: { ideal: 1280 },
                    height: { ideal: 720 },
                },
                audio: false,
            }, videoEl, onDecodeCallback);
        }

        decodePromise.catch(function(err) { handleCameraError(err); });
        $('#scannerStatus').text('Apunta al código de barras…');
    }

    function onDecodeCallback(result) {
        if (!result) return;
        var text = result.getText();
        var now = Date.now();
        if (text === lastScannedCode && (now - lastScannedAt) < 1500) return;
        lastScannedCode = text;
        lastScannedAt = now;
        $('#scannerStatus').text('Código: ' + text);
        if (navigator.vibrate) navigator.vibrate(80);
        $skuInput.val(text);
        $btnClear.show();
        closeScanner();
        lookupSku();
    }

    function stopDecoding() {
        if (codeReader) {
            try { codeReader.reset && codeReader.reset(); } catch(e) {}
            try {
                var v = document.getElementById('scannerVideo');
                if (v && v.srcObject) {
                    v.srcObject.getTracks().forEach(function(t) { t.stop(); });
                    v.srcObject = null;
                }
            } catch(e) {}
            codeReader = null;
        }
    }

    function switchCamera() {
        if (availableDevices.length < 2) { showToast('Solo hay una cámara disponible', 'info'); return; }
        currentDeviceIdx = (currentDeviceIdx + 1) % availableDevices.length;
        startDecoding();
    }

    function closeScanner() {
        stopDecoding();
        $('#scannerModal').addClass('hidden');
    }

    // Cleanup
    window.addEventListener('beforeunload', function() { stopDecoding(); });
})();
</script>
@endpush
