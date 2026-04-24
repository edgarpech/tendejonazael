<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Article;
use App\Models\Review;
use Illuminate\Support\Str;

/**
 * Controlador de páginas públicas.
 *
 * Maneja la página principal, catálogo de productos, privacidad y sitemap.
 */
class HomeController extends Controller
{
    /**
     * Muestra la página de inicio con productos, categorías y marcas.
     *
     * @return \Illuminate\View\View
     */
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

        $productsJson = $featuredProducts->map(function ($p) {
            return [
                'id' => $p->id_product,
                'name' => $p->name,
                'description' => Str::limit($p->description, 80),
                'image' => $p->main_image_url ? asset('storage/' . $p->main_image_url) : null,
                'category' => $p->category?->name ?? 'Sin categoría',
                'category_id' => $p->category_id ?? 0,
                'price' => (float) $p->price,
                'weight' => $p->weight,
            ];
        })->values();

        $reviews = Review::visible()
            ->orderByDesc('reviewed_at')
            ->take(6)
            ->get();

        return view('home', compact('featuredProducts', 'categories', 'brands', 'homeBrands', 'productsJson', 'reviews'));
    }

    /**
     * Muestra el catálogo completo de productos con filtros por categoría.
     *
     * @return \Illuminate\View\View
     */
    public function products()
    {
        $products = Product::where('is_active', 1)
            ->with(['category', 'brand'])
            ->orderBy('name')
            ->get();

        $productsJson = $products->map(function ($p) {
            return [
                'id' => $p->id_product,
                'name' => $p->name,
                'description' => $p->description ?? '',
                'image' => $p->main_image_url ? asset('storage/' . $p->main_image_url) : '',
                'category' => $p->category?->name ?? 'Sin categoría',
                'category_id' => $p->category_id ?? 0,
                'brand' => $p->brand ? $p->brand->name : '',
                'price' => (float) $p->price,
                'weight' => $p->weight ?? '',
                'created_at' => $p->created_at->toISOString(),
            ];
        });

        $categories = Category::where('is_active', 1)->withCount('products')->orderBy('name')->get();

        return view('products', compact('products', 'productsJson', 'categories'));
    }

    /**
     * Muestra la página de aviso de privacidad.
     *
     * @return \Illuminate\View\View
     */
    public function privacy()
    {
        return view('privacy');
    }

    /**
     * Muestra la página "Sobre Nosotros".
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Muestra la página de preguntas frecuentes.
     *
     * @return \Illuminate\View\View
     */
    public function faq()
    {
        return view('faq');
    }

    /**
     * Muestra el listado de artículos del blog.
     *
     * @return \Illuminate\View\View
     */
    public function blog()
    {
        $articles = Article::published()->orderByDesc('published_at')->get();

        return view('blog.index', compact('articles'));
    }

    /**
     * Muestra un artículo individual del blog.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function blogShow(string $slug)
    {
        $article = Article::published()->where('slug', $slug)->first();

        // Si el slug no existe, buscar en la tabla de redirecciones (slugs antiguos)
        // y devolver 301 al slug actual para conservar el SEO ya indexado.
        if (! $article) {
            $redirect = \App\Models\ArticleRedirect::where('old_slug', $slug)->first();
            if ($redirect && $redirect->article && $redirect->article->is_published) {
                return redirect()->route('blog.show', ['slug' => $redirect->article->slug], 301);
            }
            abort(404);
        }

        $related = Article::published()
            ->where('id_article', '!=', $article->id_article)
            ->where('category', $article->category)
            ->limit(3)
            ->get();

        return view('blog.show', compact('article', 'related'));
    }

    /**
     * Genera el sitemap XML del sitio.
     *
     * @return \Illuminate\Http\Response
     */
    public function sitemap()
    {
        $articles = Article::published()->get();

        return response()
            ->view('sitemap', compact('articles'))
            ->header('Content-Type', 'application/xml');
    }
}