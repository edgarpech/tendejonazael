<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Traits\OptimizesImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    use OptimizesImages;

    public function index(Request $request)
    {
        $articles = Article::orderByDesc('created_at')->get();

        if ($request->ajax()) {
            return response()->json($articles);
        }

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:300',
            'content' => 'required|string',
            'image' => 'nullable|image|max:4096',
            'category' => 'required|string|max:50',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $validated['is_published'] ? ($request->input('published_at') ?? now()) : null;
        $validated['content'] = clean($validated['content']);

        if ($request->hasFile('image')) {
            $validated['image'] = 'storage/' . $this->storeOptimizedImage($request->file('image'), 'articles', 1200, 630, 85);
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artículo creado exitosamente');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.form', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:300',
            'content' => 'required|string',
            'image' => 'nullable|image|max:4096',
            'category' => 'required|string|max:50',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');
        $validated['content'] = clean($validated['content']);

        if ($validated['is_published']) {
            $validated['published_at'] = $request->input('published_at') ?? $article->published_at ?? now();
        } else {
            $validated['published_at'] = null;
        }

        if ($request->hasFile('image')) {
            if ($article->image && str_starts_with($article->image, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $article->image));
            }
            $validated['image'] = 'storage/' . $this->storeOptimizedImage($request->file('image'), 'articles', 1200, 630, 85);
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artículo actualizado exitosamente');
    }

    public function destroy(Article $article)
    {
        if ($article->image && str_starts_with($article->image, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $article->image));
        }

        $article->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Artículo eliminado exitosamente']);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artículo eliminado exitosamente');
    }

    public function destroyImage(Article $article)
    {
        if ($article->image && str_starts_with($article->image, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $article->image));
        }

        $article->update(['image' => null]);

        return response()->json(['success' => true, 'message' => 'Imagen eliminada exitosamente']);
    }
}
