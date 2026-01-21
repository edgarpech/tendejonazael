<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')->latest()->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $validated['active'] = $request->has('active');

        Brand::create($validated);

        return redirect()->route('admin.brands.index')
                       ->with('success', 'Marca creada exitosamente');
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            $validated['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $validated['active'] = $request->has('active');

        $brand->update($validated);

        return redirect()->route('admin.brands.index')
                       ->with('success', 'Marca actualizada exitosamente');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->products()->count() > 0) {
            return redirect()->route('admin.brands.index')
                           ->with('error', 'No se puede eliminar una marca con productos asociados');
        }

        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')
                       ->with('success', 'Marca eliminada exitosamente');
    }
}