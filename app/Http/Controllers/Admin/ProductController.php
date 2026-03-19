<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'brand'])
        ->orderBy('name', 'asc')
        ->get();

        if ($request->ajax()) {
            return response()->json($products);
        }

        $categories = Category::where('is_active', 1)->orderBy('name')->get();
        $brands = Brand::where('is_active', 1)->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'category_id' => 'required|exists:categories,id_category',
            'brand_id' => 'nullable|exists:brands,id_brand',
            'cost_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['main_image_url'] = $request->file('image')->store('products', 'public');
        }
        unset($validated['image']);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['slug'] = Str::slug($validated['name']);

        if (empty($validated['sku'])) {
            $validated['sku'] = strtoupper(Str::random(8));
        }

        $product = Product::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Producto creado exitosamente', 'data' => $product->load(['category', 'brand'])]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto creado exitosamente');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id_product . ',id_product',
            'category_id' => 'required|exists:categories,id_category',
            'brand_id' => 'nullable|exists:brands,id_brand',
            'cost_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($product->main_image_url) {
                Storage::disk('public')->delete($product->main_image_url);
            }
            $validated['main_image_url'] = $request->file('image')->store('products', 'public');
        }
        unset($validated['image']);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['slug'] = Str::slug($validated['name']);

        $product->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Producto actualizado exitosamente', 'data' => $product->load(['category', 'brand'])]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Product $product)
    {
        if ($product->main_image_url) {
            Storage::disk('public')->delete($product->main_image_url);
        }

        $product->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Producto eliminado exitosamente']);
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado exitosamente');
    }
}
