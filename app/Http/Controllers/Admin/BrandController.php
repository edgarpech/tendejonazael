<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\OptimizesImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Controlador de administración de marcas.
 *
 * CRUD completo de marcas con soporte para carga y optimización de logos.
 */
class BrandController extends Controller
{
    use OptimizesImages;

    /**
     * Lista todas las marcas con el conteo de productos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $brands = Brand::withCount('products')->get();

        if ($request->ajax()) {
            return response()->json($brands);
        }

        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Crea una nueva marca con slug autogenerado y logo optimizado.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'show_in_home' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo_url'] = $this->storeOptimizedImage($request->file('logo'), 'brands', 300, 300, 80);
        }
        unset($validated['logo']);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['show_in_home'] = $request->boolean('show_in_home');
        $validated['slug'] = Str::slug($validated['name']);

        $brand = Brand::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Marca creada exitosamente', 'data' => $brand]);
        }

        return redirect()->route('admin.brands.index')->with('success', 'Marca creada exitosamente');
    }

    /**
     * Actualiza una marca existente. Reemplaza el logo si se sube uno nuevo.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id_brand . ',id_brand',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'show_in_home' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            if ($brand->logo_url) {
                Storage::disk('public')->delete($brand->logo_url);
            }
            $validated['logo_url'] = $this->storeOptimizedImage($request->file('logo'), 'brands', 300, 300, 80);
        }
        unset($validated['logo']);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['show_in_home'] = $request->boolean('show_in_home');
        $validated['slug'] = Str::slug($validated['name']);

        $brand->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Marca actualizada exitosamente', 'data' => $brand]);
        }

        return redirect()->route('admin.brands.index')->with('success', 'Marca actualizada exitosamente');
    }

    /**
     * Elimina una marca si no tiene productos asociados (soft delete).
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Brand $brand)
    {
        if ($brand->products()->count() > 0) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar una marca con productos asociados'], 422);
            }
            return redirect()->route('admin.brands.index')->with('error', 'No se puede eliminar una marca con productos asociados');
        }

        if ($brand->logo_url) {
            Storage::disk('public')->delete($brand->logo_url);
        }

        $brand->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Marca eliminada exitosamente']);
        }

        return redirect()->route('admin.brands.index')->with('success', 'Marca eliminada exitosamente');
    }

    /**
     * Elimina solo el logo de una marca.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroyLogo(Brand $brand)
    {
        if ($brand->logo_url) {
            Storage::disk('public')->delete($brand->logo_url);
            $brand->update(['logo_url' => null]);
        }

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Logo eliminado exitosamente']);
        }

        return redirect()->route('admin.brands.index')->with('success', 'Logo eliminado exitosamente');
    }
}
