<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request; // add this at the top

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->search);
        $category = $request->category;

        $featuredProducts = null;
        $searchProducts = null;

        if ($search || $category) {
            if ($search) {
                $searchProducts = Product::search($search)
                    ->query(fn ($q) => $q
                        ->with('productImages', 'supplier', 'category')
                        ->where('is_active', 1)
                        ->when($category, fn ($q) => $q->where('category_id', $category))
                    )
                    ->paginate(6)
                    ->withQueryString();
            } else {
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

        $categories = Category::orderBy('category_name')->get(); // add this

        return view('welcome', compact('featuredProducts', 'searchProducts', 'categories'));
    }
}
