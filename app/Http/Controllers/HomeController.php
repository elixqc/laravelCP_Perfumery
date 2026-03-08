<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->search;
        $category = $request->category;

        $featuredProducts = null;
        $searchProducts   = null;

        if ($search || $category) {

            if ($search) {
                $productIds = Product::search($search)->keys();

                $searchProducts = Product::with('productImages', 'supplier', 'category')
                    ->whereIn('product_id', $productIds)
                    ->where('is_active', 1)
                    ->when($category, fn($q) => $q->where('category_id', $category))
                    ->paginate(12)
                    ->withQueryString();
            } else {
                // category filter only, no search term
                $searchProducts = Product::with('productImages', 'supplier', 'category')
                    ->where('is_active', 1)
                    ->where('category_id', $category)
                    ->paginate(12)
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