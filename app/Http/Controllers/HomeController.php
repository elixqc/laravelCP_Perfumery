<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search   = trim($request->search);
        $category = $request->category;

        $featuredProducts = null;
        $searchProducts   = null;

        if ($search || $category) {

            if ($search) {
                // Laravel Scout search with Eloquent constraints via query()
                $searchProducts = Product::search($search)
                    ->query(fn ($q) => $q
                        ->with('productImages', 'supplier', 'category')
                        ->where('is_active', 1)
                        ->when($category, fn ($q) => $q->where('category_id', $category))
                    )
                    ->paginate(6)
                    ->withQueryString();

            } else {
                // Category filter only — no search term, plain Eloquent
                $searchProducts = Product::with('productImages', 'supplier', 'category')
                    ->where('is_active', 1)
                    ->where('category_id', $category)
                    ->latest('product_id')
                    ->paginate(6)
                    ->withQueryString();
            }

        } else {
            $featuredProducts = Product::with('productImages', 'supplier', 'category')
                ->where('is_active', 1)
                ->latest('product_id')
                ->take(6)
                ->get();
        }

        return view('welcome', compact('featuredProducts', 'searchProducts'));
    }
}