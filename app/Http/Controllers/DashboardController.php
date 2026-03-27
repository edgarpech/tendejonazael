<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;

/**
 * Controlador del panel de administración.
 *
 * Muestra estadísticas generales y productos recientes.
 */
class DashboardController extends Controller
{
    /**
     * Muestra el dashboard con estadísticas de productos, categorías, marcas y usuarios.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'active_products' => Product::where('is_active', 1)->count(),
            'categories' => Category::count(),
            'brands' => Brand::count(),
            'users' => User::count(),
        ];

        $recent_products = Product::with(['category', 'brand'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_products'));
    }
}