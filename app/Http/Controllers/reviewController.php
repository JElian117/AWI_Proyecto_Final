<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Album;
use Illuminate\Support\Facades\Auth;

class reviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('album')->where('user_id', Auth::id())->get();
        $albums = Album::all();
        
        return view('crudReviews', compact('reviews', 'albums'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'review' => 'required|string',
            'rating' => 'required|integer|min:0|max:10',
        ]);

        $nuevoReview = new Review();
        $nuevoReview->album_id = $request->album_id;
        $nuevoReview->user_id = Auth::id(); // ID del usuario autenticado
        $nuevoReview->review = $request->review;
        $nuevoReview->rating = $request->rating;
        $nuevoReview->save();

        return redirect()->back()->with('success', 'Reseña creada exitosamente.');
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return view('editarMisReview', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'review' => 'required|string',
            'rating' => 'required|integer|min:0|max:10',
        ]);

        $review = Review::findOrFail($id);
        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->save();

        return redirect()->route('reviews.index')->with('success', 'Reseña actualizada exitosamente.');
    }

    public function delete($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->back()->with('success', 'Reseña eliminada exitosamente.');
    }
}
