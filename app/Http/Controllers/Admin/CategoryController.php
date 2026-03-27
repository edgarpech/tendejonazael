<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Controlador de administración de categorías.
 *
 * CRUD completo de categorías de productos.
 */
class CategoryController extends Controller
{
    /**
     * Lista todas las categorías con el conteo de productos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->get();

        if ($request->ajax()) {
            return response()->json($categories);
        }

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Crea una nueva categoría con slug autogenerado.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['slug'] = Str::slug($validated['name']);

        $category = Category::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Categoría creada exitosamente', 'data' => $category]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Categoría creada exitosamente');
    }

    /**
     * Actualiza una categoría existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id_category . ',id_category',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Categoría actualizada exitosamente', 'data' => $category]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Categoría actualizada exitosamente');
    }

    /**
     * Elimina una categoría si no tiene productos asociados (soft delete).
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar una categoría con productos asociados'], 422);
            }
            return redirect()->route('admin.categories.index')->with('error', 'No se puede eliminar una categoría con productos asociados');
        }

        $category->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Categoría eliminada exitosamente']);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Categoría eliminada exitosamente');
    }
}
