<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', 1)
            ->withCount('products')
            ->orderBy('name')
            ->get();

        $featuredProducts = Product::where('is_active', 1)
            ->with(['category', 'brand'])
            ->orderBy('name')
            ->get();

        $brands = Brand::where('is_active', 1)
            ->orderBy('name')
            ->get();

        $homeBrands = Brand::where('is_active', 1)
            ->where('show_in_home', 1)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('home', compact('featuredProducts', 'categories', 'brands', 'homeBrands'));
    }

    public function products()
    {
        $products = Product::where('is_active', 1)
            ->with(['category', 'brand'])
            ->orderBy('name')
            ->get();

        $categories = Category::where('is_active', 1)->withCount('products')->orderBy('name')->get();

        return view('products', compact('products', 'categories'));
    }

    public function sitemap()
    {
        return response()
            ->view('sitemap')
            ->header('Content-Type', 'application/xml');
    }
}