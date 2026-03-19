<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::withCount('products')->get();

        if ($request->ajax()) {
            return response()->json($brands);
        }

        return view('admin.brands.index', compact('brands'));
    }

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
            $validated['logo_url'] = $request->file('logo')->store('brands', 'public');
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
            $validated['logo_url'] = $request->file('logo')->store('brands', 'public');
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
}
