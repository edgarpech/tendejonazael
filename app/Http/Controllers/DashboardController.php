<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use App\Models\Gallery;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'categories' => Category::count(),
            'brands' => Brand::count(),
            'users' => User::count(),
            'gallery_images' => Gallery::count(),
        ];

        $recent_products = Product::with(['category', 'brand'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_products'));
    }
}