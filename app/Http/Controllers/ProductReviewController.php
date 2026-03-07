<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    // Store or update a review
    public function storeOrUpdate(Request $request, $productId)
    {
        $user = Auth::user();
        $product = Product::findOrFail($productId);

        // Only allow review if user bought the product
        $hasPurchased = OrderDetail::where('product_id', $productId)
            ->whereHas('order', function ($q) use ($user) {
                $q->where('user_id', $user->user_id);
            })->exists();
        if (!$hasPurchased) {
            return back()->with('error', 'You can only review products you have purchased.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:2000',
        ]);

        $review = ProductReview::updateOrCreate(
            [
                'product_id' => $productId,
                'user_id' => $user->user_id,
            ],
            [
                'rating' => $request->rating,
                'review_text' => $request->review_text,
                'date_reviewed' => now(),
            ]
        );

        return back()->with('success', 'Your review has been submitted.');
    }

    // Admin: List all reviews (for DataTable)
    public function index()
    {
        if (request()->ajax()) {
            $reviews = ProductReview::with(['product', 'user'])->select('product_reviews.*');
            return datatables()->of($reviews)
                ->addColumn('product_name', function($r) { return $r->product->product_name ?? '-'; })
                ->addColumn('user_name', function($r) { return $r->user->full_name ?? $r->user->username ?? '-'; })
                ->addColumn('action', function($r) {
                    return '<button class="btn btn-danger btn-sm" onclick="deleteReview('.$r->review_id.')">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.reviews.index');
    }

    // Admin: Delete a review
    public function destroy($reviewId)
    {
        $review = ProductReview::findOrFail($reviewId);
        $review->delete();
        return response()->json(['success' => true]);
    }
}
