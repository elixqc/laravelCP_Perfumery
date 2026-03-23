<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReviewController extends Controller
{
    /**
     * All reviews index + DataTables ajax endpoint.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ProductReview::with('product', 'user')
                ->select('product_reviews.*');

            return DataTables::of($query)
                ->addColumn('product_name', fn ($r) => $r->product?->product_name ?? '—')
                ->addColumn('user_name', fn ($r) => $r->user?->full_name ?? $r->user?->username ?? '—')
                ->addColumn('rating', fn ($r) => $r->rating)
                ->addColumn('review_text', fn ($r) => $r->review_text)
                ->addColumn('review_date', fn ($r) => optional($r->review_date ?? $r->created_at)?->toDateString())
                ->rawColumns([])
                ->make(true);
        }

        return view('admin.reviews.index');
    }

    /**
     * Delete a single review.
     */
    public function destroy($id)
    {
        ProductReview::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }
}
