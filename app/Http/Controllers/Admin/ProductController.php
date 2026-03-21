<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplyLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }

    public function data(Request $request)
    {
        $query = Product::with('productImages')
            ->withTrashed()
            ->select('products.*');

        return DataTables::of($query)
            ->addColumn('name_col', function (Product $product) {
                $thumb = $product->productImages->first();
                $thumbUrl = $thumb ? asset('storage/'.$thumb->image_path) : null;

                $imgHtml = $thumbUrl
                    ? "<div class='pa-product-thumb'>
                            <img src='{$thumbUrl}' alt='' class='pa-product-thumb'>
                       </div>"
                    : "<div class='pa-product-thumb--empty'>
                            <span>N/A</span>
                       </div>";

                $name = e($product->product_name);
                $variantHtml = $product->variant
                    ? "<span style='font-size:0.72rem;color:#8C8078;font-family:Jost,sans-serif;font-weight:300;display:block;'>".e($product->variant).'</span>'
                    : '';

                return "<div class='pa-product-cell'>
                            {$imgHtml}
                            <div>
                                <span class='pa-product-name'>{$name}</span>
                                {$variantHtml}
                            </div>
                        </div>";
            })
            ->addColumn('cost_price', function (Product $product) {
                if ($product->initial_price !== null) {
                    return "<span class='pa-price pa-price--cost'>₱".number_format($product->initial_price, 2).'</span>';
                }

                return "<span style='color:#C8BEB2;'>—</span>";
            })
            ->addColumn('sell_price', function (Product $product) {
                if ($product->selling_price !== null) {
                    return "<span class='pa-price pa-price--sell'>₱".number_format($product->selling_price, 2).'</span>';
                }

                return "<span style='color:#C8BEB2;font-size:0.88rem;'>—</span>";
            })
            ->addColumn('stock', function (Product $product) {
                $qty = $product->stock_quantity;
                $cls = $qty > 10 ? 'pa-stock' : ($qty > 0 ? 'pa-stock pa-stock--low' : 'pa-stock pa-stock--zero');

                return "<span class='{$cls}'>{$qty}</span>";
            })
            ->addColumn('status_display', function (Product $product) {
                $cls = $product->is_active ? 'pa-status pa-status--success' : 'pa-status pa-status--danger';
                $label = $product->is_active ? 'Active' : 'Inactive';

                $html = "<div style='display:flex;flex-wrap:wrap;gap:0.4rem;align-items:center;'>
                            <span class='{$cls}'>{$label}</span>";

                if ($product->trashed()) {
                    $html .= "<span class='pa-status pa-status--danger'>Deleted</span>";
                }

                return $html.'</div>';
            })
            ->addColumn('actions', function (Product $product) {
                // ── Trashed: show Restore only ──
                if ($product->trashed()) {
                    $restoreUrl = route('admin.products.restore', $product->product_id);
                    $csrf = csrf_token();

                    return "<form method='POST' action='{$restoreUrl}' style='display:inline;'>
                                <input type='hidden' name='_token' value='{$csrf}'>
                                <button type='submit' class='pa-action-link' style='color:#4A6741;'>Restore</button>
                            </form>";
                }

                // ── Active: Edit | Reviews | Delete ──
                $editUrl = route('admin.products.edit', $product->product_id);
                $reviewsUrl = route('admin.products.reviews', $product->product_id);
                $productId = $product->product_id;
                $productName = e($product->product_name);

                return "<div style='display:flex;align-items:center;gap:0;white-space:nowrap;'>
                            <a href='{$editUrl}' class='pa-action-link'>Edit</a>
                            <span class='pa-action-sep'></span>
                            <a href='{$reviewsUrl}' class='pa-action-link'>Reviews</a>
                            <span class='pa-action-sep'></span>
                            <button type='button'
                                class='pa-action-link pa-action-link--danger pa-product-delete'
                                data-product-id='{$productId}'
                                data-product-name='{$productName}'>
                                Delete
                            </button>
                        </div>";
            })
            ->with('stats', [
                'total' => Product::withTrashed()->count(),
                'active' => Product::withoutTrashed()->where('is_active', true)->count(),
                'inactive' => Product::withoutTrashed()->where('is_active', false)->count(),
            ])
            ->rawColumns(['name_col', 'cost_price', 'sell_price', 'stock', 'status_display', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|min:2|max:255',
            'description' => 'nullable|string|min:10|max:2000',
            'initial_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'product_name.required' => 'Product name is required.',
            'product_name.min' => 'Product name must be at least 2 characters.',
            'product_name.max' => 'Product name cannot exceed 255 characters.',
            'description.min' => 'Description must be at least 10 characters.',
            'description.max' => 'Description cannot exceed 2000 characters.',
            'initial_price.numeric' => 'Cost price must be a valid number.',
            'initial_price.min' => 'Cost price cannot be negative.',
            'selling_price.numeric' => 'Selling price must be a valid number.',
            'selling_price.min' => 'Selling price cannot be negative.',
            'stock_quantity.required' => 'Stock quantity is required.',
            'stock_quantity.integer' => 'Stock quantity must be a whole number.',
            'stock_quantity.min' => 'Stock quantity cannot be negative.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category is invalid.',
            'supplier_id.required' => 'Please select a supplier.',
            'supplier_id.exists' => 'Selected supplier is invalid.',
            'images.*.image' => 'Each file must be a valid image.',
            'images.*.mimes' => 'Images must be JPG, PNG, or WEBP.',
            'images.*.max' => 'Each image must not exceed 4MB.',
        ]);

        $data = $request->except('images');

        if (empty($data['initial_price']) && empty($data['selling_price']) && $request->filled('price')) {
            $data['initial_price'] = $request->input('price');
            $data['selling_price'] = $request->input('price');
        }

        $product = Product::create($data);

        SupplyLog::create([
            'product_id' => $product->product_id,
            'supplier_id' => $product->supplier_id,
            'quantity_added' => $product->stock_quantity,
            'supplier_price' => $product->initial_price,
            'remarks' => 'Initial stock on product creation',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');
                $product->productImages()->create([
                    'image_path' => $path,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_name' => 'required|string|min:2|max:255',
            'description' => 'nullable|string|min:10|max:2000',
            'initial_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'product_name.required' => 'Product name is required.',
            'product_name.min' => 'Product name must be at least 2 characters.',
            'product_name.max' => 'Product name cannot exceed 255 characters.',
            'description.min' => 'Description must be at least 10 characters.',
            'description.max' => 'Description cannot exceed 2000 characters.',
            'initial_price.numeric' => 'Cost price must be a valid number.',
            'initial_price.min' => 'Cost price cannot be negative.',
            'selling_price.numeric' => 'Selling price must be a valid number.',
            'selling_price.min' => 'Selling price cannot be negative.',
            'stock_quantity.required' => 'Stock quantity is required.',
            'stock_quantity.integer' => 'Stock quantity must be a whole number.',
            'stock_quantity.min' => 'Stock quantity cannot be negative.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category is invalid.',
            'supplier_id.required' => 'Please select a supplier.',
            'supplier_id.exists' => 'Selected supplier is invalid.',
            'images.*.image' => 'Each file must be a valid image.',
            'images.*.mimes' => 'Images must be JPG, PNG, or WEBP.',
            'images.*.max' => 'Each image must not exceed 4MB.',
        ]);

        $data = $request->except('images');

        if (empty($data['initial_price']) && empty($data['selling_price']) && $request->filled('price')) {
            $data['initial_price'] = $request->input('price');
            $data['selling_price'] = $request->input('price');
        }

        $oldQty = $product->stock_quantity;
        $product->update($data);
        $newQty = $product->stock_quantity;
        $qtyDiff = $newQty - $oldQty;

        if ($qtyDiff > 0) {
            SupplyLog::create([
                'product_id' => $product->product_id,
                'supplier_id' => $product->supplier_id,
                'quantity_added' => $qtyDiff,
                'supplier_price' => $product->initial_price,
                'remarks' => 'Stock increased via product update',
            ]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');
                $product->productImages()->create([
                    'image_path' => $path,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    /**
     * Soft-delete — called via axios.delete() from the modal.
     * Must return JSON, not a redirect.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete(); // soft delete (uses SoftDeletes trait)

        return response()->json([
            'success' => true,
            'message' => 'Product archived successfully.',
        ]);
    }

    public function destroyImage($imageId)
    {
        $image = \App\Models\ProductImage::findOrFail($imageId);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }
}
