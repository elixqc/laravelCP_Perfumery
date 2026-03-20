<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
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
                $thumb    = $product->productImages->first();
                $thumbUrl = $thumb ? asset('storage/' . $thumb->image_path) : null;

                $imgHtml = $thumbUrl
                    ? "<div style='width:42px;height:42px;overflow:hidden;background:#EDE8DF;border:1px solid #D6D0C8;flex-shrink:0;'>
                        <img src='{$thumbUrl}' alt='' style='width:100%;height:100%;object-fit:cover;display:block;'>
                    </div>"
                    : "<div style='width:42px;height:42px;background:#EDE8DF;border:1px solid #D6D0C8;flex-shrink:0;display:flex;align-items:center;justify-content:center;'>
                        <span style='font-size:0.55rem;color:#B0A898;font-family:Jost,sans-serif;'>N/A</span>
                    </div>";

                $name        = e($product->product_name);
                $variantHtml = $product->variant
                    ? "<span style='font-size:0.72rem;color:#8C8078;font-family:Jost,sans-serif;font-weight:300;'>" . e($product->variant) . "</span>"
                    : '';

                return "<div style='display:flex;align-items:center;gap:0.85rem;'>
                            {$imgHtml}
                            <div>
                                <span style='font-size:0.92rem;color:#1A1714;font-family:Jost,sans-serif;font-weight:400;display:block;line-height:1.3;'>{$name}</span>
                                {$variantHtml}
                            </div>
                        </div>";
            })
            ->addColumn('cost_price', function (Product $product) {
                if ($product->initial_price !== null) {
                    return "<span style='font-size:0.88rem;color:#5A524A;font-family:Jost,sans-serif;font-weight:300;'>₱" . number_format($product->initial_price, 2) . "</span>";
                }
                return "<span style='color:#C8BEB2;'>—</span>";
            })
            ->addColumn('sell_price', function (Product $product) {
                if ($product->selling_price !== null) {
                    return "<span style=\"font-family:'Cormorant Garamond',serif;font-size:1.05rem;font-weight:300;color:#B5975A;letter-spacing:0.02em;\">₱" . number_format($product->selling_price, 2) . "</span>";
                }
                return "<span style='color:#C8BEB2;font-size:0.88rem;'>—</span>";
            })
            ->addColumn('stock', function (Product $product) {
                $qty   = $product->stock_quantity;
                $color = $qty > 10 ? '#4A6741' : ($qty > 0 ? '#856404' : '#8B3A3A');
                $bg    = $qty > 10 ? '#F0F5EE' : ($qty > 0 ? '#FEF3CD' : '#F8EEEE');
                return "<span style='display:inline-block;background:{$bg};color:{$color};font-family:Jost,sans-serif;font-size:0.75rem;font-weight:500;letter-spacing:0.08em;padding:0.2rem 0.65rem;border-radius:2px;'>{$qty}</span>";
            })
            ->addColumn('status_display', function (Product $product) {
                $activeBg    = $product->is_active ? '#F0F5EE' : '#F8EEEE';
                $activeColor = $product->is_active ? '#4A6741' : '#8B3A3A';
                $activeLabel = $product->is_active ? 'Active' : 'Inactive';

                $html = "<div style='display:flex;flex-wrap:wrap;gap:0.4rem;align-items:center;'>
                            <span style='display:inline-block;font-size:0.68rem;letter-spacing:0.15em;text-transform:uppercase;font-family:Jost,sans-serif;font-weight:400;padding:0.25rem 0.7rem;border-radius:2px;background:{$activeBg};color:{$activeColor};'>{$activeLabel}</span>";

                if ($product->trashed()) {
                    $html .= "<span style='display:inline-block;font-size:0.68rem;letter-spacing:0.15em;text-transform:uppercase;font-family:Jost,sans-serif;font-weight:400;padding:0.25rem 0.7rem;background:#F8EEEE;color:#8B3A3A;border-radius:2px;'>Deleted</span>";
                }

                return $html . "</div>";
            })
            ->addColumn('actions', function (Product $product) {
                $csrf = csrf_token();

                if ($product->trashed()) {
                    $restoreUrl = route('admin.products.restore', $product->product_id);
                    return "<form method='POST' action='{$restoreUrl}' style='display:inline;' onsubmit=\"return confirm('Restore this product?')\">
                                <input type='hidden' name='_token' value='{$csrf}'>
                                <button type='submit'
                                    style='background:none;border:none;cursor:pointer;font-family:Jost,sans-serif;font-size:0.78rem;font-weight:400;letter-spacing:0.08em;color:#4A6741;padding:0;'>Restore</button>
                            </form>";
                }

                $editUrl    = route('admin.products.edit', $product->product_id);
                $reviewsUrl = route('admin.products.reviews', $product->product_id);
                $deleteUrl  = route('admin.products.destroy', $product->product_id);

                return "<div style='display:flex;align-items:center;gap:1rem;white-space:nowrap;'>
                            <a href='{$editUrl}'
                            style='font-family:Jost,sans-serif;font-size:0.78rem;font-weight:400;letter-spacing:0.08em;color:#2C2825;text-decoration:none;border-bottom:1px solid transparent;padding-bottom:1px;'
                            onmouseover=\"this.style.color='#B5975A';this.style.borderBottomColor='#B5975A'\"
                            onmouseout=\"this.style.color='#2C2825';this.style.borderBottomColor='transparent'\">Edit</a>
                            <span style='color:#D6D0C8;font-size:0.7rem;'>|</span>
                            <a href='{$reviewsUrl}'
                            style='font-family:Jost,sans-serif;font-size:0.78rem;font-weight:400;letter-spacing:0.08em;color:#4A6741;text-decoration:none;border-bottom:1px solid transparent;padding-bottom:1px;'
                            onmouseover=\"this.style.color='#B5975A';this.style.borderBottomColor='#B5975A'\"
                            onmouseout=\"this.style.color='#4A6741';this.style.borderBottomColor='transparent'\">Reviews</a>
                            <span style='color:#D6D0C8;font-size:0.7rem;'>|</span>
                            <form method='POST' action='{$deleteUrl}' style='display:inline;' onsubmit=\"return confirm('Delete this product? This action cannot be undone.')\">
                                <input type='hidden' name='_token' value='{$csrf}'>
                                <input type='hidden' name='_method' value='DELETE'>
                                <button type='submit'
                                    style='background:none;border:none;cursor:pointer;font-family:Jost,sans-serif;font-size:0.78rem;font-weight:400;letter-spacing:0.08em;color:#8B3A3A;padding:0;'
                                    onmouseover=\"this.style.color='#C97A7A'\"
                                    onmouseout=\"this.style.color='#8B3A3A'\">Delete</button>
                            </form>
                        </div>";
            })
            ->with('stats', [
                'total'    => Product::withTrashed()->count(),
                'active'   => Product::withoutTrashed()->where('is_active', true)->count(),
                'inactive' => Product::withoutTrashed()->where('is_active', false)->count(),
            ])
            ->rawColumns(['name_col', 'cost_price', 'sell_price', 'stock', 'status_display', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers  = Supplier::all();
        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name'   => 'required|string|min:2|max:255',
            'description'    => 'nullable|string|min:10|max:2000',
            'initial_price'  => 'nullable|numeric|min:0',
            'selling_price'  => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id'    => 'required|exists:categories,category_id',
            'supplier_id'    => 'required|exists:suppliers,supplier_id',
            'images'         => 'nullable|array',
            'images.*'       => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'product_name.required'   => 'Product name is required.',
            'product_name.min'        => 'Product name must be at least 2 characters.',
            'product_name.max'        => 'Product name cannot exceed 255 characters.',
            'description.min'         => 'Description must be at least 10 characters.',
            'description.max'         => 'Description cannot exceed 2000 characters.',
            'initial_price.numeric'   => 'Cost price must be a valid number.',
            'initial_price.min'       => 'Cost price cannot be negative.',
            'selling_price.numeric'   => 'Selling price must be a valid number.',
            'selling_price.min'       => 'Selling price cannot be negative.',
            'stock_quantity.required' => 'Stock quantity is required.',
            'stock_quantity.integer'  => 'Stock quantity must be a whole number.',
            'stock_quantity.min'      => 'Stock quantity cannot be negative.',
            'category_id.required'   => 'Please select a category.',
            'category_id.exists'     => 'Selected category is invalid.',
            'supplier_id.required'   => 'Please select a supplier.',
            'supplier_id.exists'     => 'Selected supplier is invalid.',
            'images.*.image'         => 'Each file must be a valid image.',
            'images.*.mimes'         => 'Images must be JPG, PNG, or WEBP.',
            'images.*.max'           => 'Each image must not exceed 4MB.',
        ]);

        $data = $request->except('images');

        if (empty($data['initial_price']) && empty($data['selling_price']) && $request->filled('price')) {
            $data['initial_price'] = $request->input('price');
            $data['selling_price'] = $request->input('price');
        }

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');
                $product->productImages()->create([
                    'image_path'  => $path,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::all();
        $suppliers  = Supplier::all();
        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_name'   => 'required|string|min:2|max:255',
            'description'    => 'nullable|string|min:10|max:2000',
            'initial_price'  => 'nullable|numeric|min:0',
            'selling_price'  => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id'    => 'required|exists:categories,category_id',
            'supplier_id'    => 'required|exists:suppliers,supplier_id',
            'images'         => 'nullable|array',
            'images.*'       => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'product_name.required'   => 'Product name is required.',
            'product_name.min'        => 'Product name must be at least 2 characters.',
            'product_name.max'        => 'Product name cannot exceed 255 characters.',
            'description.min'         => 'Description must be at least 10 characters.',
            'description.max'         => 'Description cannot exceed 2000 characters.',
            'initial_price.numeric'   => 'Cost price must be a valid number.',
            'initial_price.min'       => 'Cost price cannot be negative.',
            'selling_price.numeric'   => 'Selling price must be a valid number.',
            'selling_price.min'       => 'Selling price cannot be negative.',
            'stock_quantity.required' => 'Stock quantity is required.',
            'stock_quantity.integer'  => 'Stock quantity must be a whole number.',
            'stock_quantity.min'      => 'Stock quantity cannot be negative.',
            'category_id.required'   => 'Please select a category.',
            'category_id.exists'     => 'Selected category is invalid.',
            'supplier_id.required'   => 'Please select a supplier.',
            'supplier_id.exists'     => 'Selected supplier is invalid.',
            'images.*.image'         => 'Each file must be a valid image.',
            'images.*.mimes'         => 'Images must be JPG, PNG, or WEBP.',
            'images.*.max'           => 'Each image must not exceed 4MB.',
        ]);

        $data = $request->except('images');

        if (empty($data['initial_price']) && empty($data['selling_price']) && $request->filled('price')) {
            $data['initial_price'] = $request->input('price');
            $data['selling_price'] = $request->input('price');
        }

        $product->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');
                $product->productImages()->create([
                    'image_path'  => $path,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    public function destroyImage($imageId)
    {
        $image = \App\Models\ProductImage::findOrFail($imageId);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }
}