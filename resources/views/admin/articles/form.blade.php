@extends('layouts.app')

@section('title', isset($article) ? 'Editar Artículo' : 'Nuevo Artículo')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="admin-title text-2xl font-bold text-gray-900 dark:text-white">{{ isset($article) ? 'Editar Artículo' : 'Nuevo Artículo' }}</h1>
            <p class="admin-subtitle text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('admin.articles.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">← Volver a artículos</a>
            </p>
        </div>
        @if(isset($article))
            <a href="{{ route('blog.show', $article->slug) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Ver en blog
            </a>
        @endif
    </div>

    <form action="{{ isset($article) ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" id="articleForm">
        @csrf
        @if(isset($article))
            @method('PUT')
        @endif

        <div class="space-y-6">
            {{-- Título y Categoría --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Título *</label>
                        <input type="text" name="title" id="fTitle" class="fi" value="{{ old('title', $article->title ?? '') }}" placeholder="Título del artículo" required>
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Categoría *</label>
                        <select name="category" id="fCategory" class="fi" required>
                            <option value="">Seleccionar</option>
                            @foreach(['guias' => 'Guías', 'recomendaciones' => 'Recomendaciones', 'chabihau' => 'Chabihau', 'comunidad' => 'Comunidad', 'gastronomia' => 'Gastronomía', 'turismo' => 'Turismo', 'cultura' => 'Cultura', 'naturaleza' => 'Naturaleza', 'consejos' => 'Consejos', 'historia' => 'Historia', 'general' => 'General'] as $cat => $label)
                                <option value="{{ $cat }}" {{ old('category', $article->category ?? '') === $cat ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Extracto --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Extracto * <span class="font-normal text-gray-400">(máx. 300 caracteres)</span></label>
                <textarea name="excerpt" id="fExcerpt" class="fi" rows="2" maxlength="300" placeholder="Breve descripción del artículo para el listado y SEO" required>{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
                <p class="text-xs text-gray-400 mt-1"><span id="excerptCount">0</span>/300</p>
                @error('excerpt')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Imagen destacada --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Imagen destacada</label>
                @if(isset($article) && $article->image)
                    <div id="currentImage" class="mb-3 flex items-center gap-4">
                        <img src="{{ asset($article->image) }}" class="w-32 h-20 rounded-lg object-cover" alt="">
                        <button type="button" id="btnDeleteImage" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium flex items-center gap-1 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Eliminar imagen
                        </button>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300">
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contenido con TinyMCE --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contenido *</label>
                <textarea name="content" id="editor">{{ old('content', $article->content ?? '') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Publicación y acciones --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $article->is_published ?? true) ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Publicar artículo</span>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">Cancelar</a>
                        <button type="submit" class="btn-save px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                            {{ isset($article) ? 'Actualizar' : 'Crear Artículo' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .tox-tinymce { border-radius: 0.5rem !important; border-color: #d1d5db !important; }
    .dark .tox-tinymce { border-color: #4b5563 !important; }
    .dark .tox .tox-edit-area__iframe { background-color: #1f2937 !important; }
    .dark .tox .tox-toolbar__primary,
    .dark .tox .tox-toolbar__overflow,
    .dark .tox .tox-toolbar,
    .dark .tox .tox-menubar { background-color: #374151 !important; }
    .dark .tox .tox-tbtn,
    .dark .tox .tox-mbtn { color: #d1d5db !important; }
    .dark .tox .tox-tbtn:hover,
    .dark .tox .tox-mbtn:hover { background-color: #4b5563 !important; }
    .dark .tox .tox-statusbar { background-color: #374151 !important; color: #9ca3af !important; }
    .dark .tox .tox-statusbar__text-container { color: #9ca3af !important; }
    .dark .tox .tox-statusbar a { color: #9ca3af !important; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
$(function() {
    // Excerpt counter
    var $excerpt = $('#fExcerpt');
    function updateCount() { $('#excerptCount').text($excerpt.val().length); }
    $excerpt.on('input', updateCount);
    updateCount();

    // Delete image
    $('#btnDeleteImage').on('click', function() {
        confirmAction('¿Eliminar la imagen destacada?').then(function(r) {
            if (r.isConfirmed) {
                $.ajax({
                    url: '/admin/articles/{{ $article->id_article ?? 0 }}/image',
                    method: 'DELETE',
                    success: function(res) {
                        $('#currentImage').fadeOut(200, function() { $(this).remove(); });
                        showToast(res.message, 'success');
                    },
                    error: handleAjaxError
                });
            }
        });
    });

    // TinyMCE
    function initTinyMCE() {
        var isDark = document.documentElement.classList.contains('dark');
        tinymce.init({
            selector: '#editor',
            base_url: 'https://cdn.jsdelivr.net/npm/tinymce@7',
            suffix: '.min',
            language: 'es_MX',
            language_url: 'https://cdn.jsdelivr.net/npm/tinymce-i18n@24/langs7/es_MX.min.js',
            height: 500,
            menubar: 'file edit insert format table',
            plugins: 'lists link image table code wordcount fullscreen preview autoresize',
            toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | link image table | code fullscreen',
            block_formats: 'Párrafo=p; Encabezado 2=h2; Encabezado 3=h3; Encabezado 4=h4; Cita=blockquote',
            content_style: isDark
                ? 'body { font-family: Inter, system-ui, sans-serif; font-size: 16px; line-height: 1.75; color: #d1d5db; background-color: #1f2937; } a { color: #22d3ee; } h2, h3, h4 { color: #f3f4f6; }'
                : 'body { font-family: Inter, system-ui, sans-serif; font-size: 16px; line-height: 1.75; color: #374151; } a { color: #0891b2; }',
            skin: isDark ? 'oxide-dark' : 'oxide',
            content_css: isDark ? 'dark' : 'default',
            branding: false,
            promotion: false,
            license_key: 'gpl',
            valid_elements: 'p,br,strong/b,em/i,u,s,h2,h3,h4,blockquote,ul,ol,li,a[href|target|rel],img[src|alt|width|height|class],table,thead,tbody,tr,th,td,figure,figcaption,span[style],sub,sup,hr,pre,code',
            automatic_uploads: false,
            file_picker_types: '',
            paste_as_text: false,
            paste_block_drop: false,
            smart_paste: true,
            autoresize_min_height: 400,
            autoresize_max_height: 800,
            setup: function(editor) {
                editor.on('change', function() {
                    tinymce.triggerSave();
                });
            }
        });
    }

    initTinyMCE();

    // Re-init TinyMCE when dark mode toggles
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(m) {
            if (m.attributeName === 'class') {
                tinymce.triggerSave();
                tinymce.remove('#editor');
                initTinyMCE();
            }
        });
    });
    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

    // Ensure TinyMCE content is saved before form submit
    $('#articleForm').on('submit', function() {
        tinymce.triggerSave();
    });
});
</script>
@endpush
