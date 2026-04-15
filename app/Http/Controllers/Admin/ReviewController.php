<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::orderByDesc('reviewed_at')->get();

        if ($request->ajax()) {
            return response()->json($reviews);
        }

        return view('admin.reviews.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'source' => 'nullable|string|max:50',
            'is_visible' => 'boolean',
            'reviewed_at' => 'nullable|date',
        ]);

        $validated['is_visible'] = $request->boolean('is_visible');
        $validated['source'] = $validated['source'] ?: 'google';
        $validated['reviewed_at'] = $validated['reviewed_at'] ?: now();

        $review = Review::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Reseña creada exitosamente', 'data' => $review]);
        }

        return redirect()->route('admin.reviews.index')->with('success', 'Reseña creada exitosamente');
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'source' => 'nullable|string|max:50',
            'is_visible' => 'boolean',
            'reviewed_at' => 'nullable|date',
        ]);

        $validated['is_visible'] = $request->boolean('is_visible');

        $review->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Reseña actualizada exitosamente', 'data' => $review]);
        }

        return redirect()->route('admin.reviews.index')->with('success', 'Reseña actualizada exitosamente');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Reseña eliminada exitosamente']);
        }

        return redirect()->route('admin.reviews.index')->with('success', 'Reseña eliminada exitosamente');
    }
}
