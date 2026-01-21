<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('sku', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%");
            });
        }

        // Filtro por categoría
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filtro por marca
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::where('active', true)->orderBy('name')->get();
        $brands = Brand::where('active', true)->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $categories = Category::where('active', true)->orderBy('name')->get();
        $brands = Brand::where('active', true)->orderBy('name')->get();
        
        return view('admin.products.form', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'active' => 'boolean',
            'featured' => 'boolean',
        ]);

        // Manejar imagen
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['active'] = $request->has('active');
        $validated['featured'] = $request->has('featured');

        Product::create($validated);

        return redirect()->route('admin.products.index')
                       ->with('success', 'Producto creado exitosamente');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('active', true)->orderBy('name')->get();
        $brands = Brand::where('active', true)->orderBy('name')->get();
        
        return view('admin.products.form', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'active' => 'boolean',
            'featured' => 'boolean',
        ]);

        // Manejar imagen
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['active'] = $request->has('active');
        $validated['featured'] = $request->has('featured');

        $product->update($validated);

        return redirect()->route('admin.products.index')
                       ->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Product $product)
    {
        // Eliminar imagen
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
                       ->with('success', 'Producto eliminado exitosamente');
    }
}