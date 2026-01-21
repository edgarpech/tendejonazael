<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('active', true)
                                   ->where('featured', true)
                                   ->with(['category', 'brand'])
                                   ->latest()
                                   ->take(8)
                                   ->get();

        $categories = Category::where('active', true)
                             ->withCount('products')
                             ->orderBy('name')
                             ->get();

        $brands = Brand::where('active', true)
                      ->orderBy('name')
                      ->get();

        return view('home', compact('featuredProducts', 'categories', 'brands'));
    }

    public function products(Request $request)
    {
        $query = Product::where('active', true)->with(['category', 'brand']);

        // Filtros
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('brand')) {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%");
            });
        }

        // Ordenar
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::where('active', true)->withCount('products')->get();
        $brands = Brand::where('active', true)->get();

        return view('products', compact('products', 'categories', 'brands'));
    }

    public function show(Product $product)
    {
        if (!$product->active) {
            abort(404);
        }

        $product->load(['category', 'brand']);
        
        $relatedProducts = Product::where('active', true)
                                  ->where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->take(4)
                                  ->get();

        return view('product-detail', compact('product', 'relatedProducts'));
    }
}