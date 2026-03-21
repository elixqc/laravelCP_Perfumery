<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }

    public function data(Request $request)
    {
        $query = Category::withTrashed()
            ->select('category_id', 'category_name', 'deleted_at');

        return DataTables::of($query)
            ->addColumn('name_col', function (Category $category) {
                $name = e($category->category_name);

                return "<span class='u-name' style='font-style:italic;'>{$name}</span>";
            })
            ->addColumn('status_col', function (Category $category) {
                if ($category->trashed()) {
                    return "<span class='pa-status pa-status--danger'>Archived</span>";
                }

                return "<span class='pa-status pa-status--success'>Active</span>";
            })
            ->addColumn('actions', function (Category $category) {
                // Trashed — Restore only
                if ($category->trashed()) {
                    $restoreUrl = route('admin.categories.restore', $category->category_id);
                    $csrf = csrf_token();

                    return "<form method='POST' action='{$restoreUrl}' style='display:inline;'>
                                <input type='hidden' name='_token' value='{$csrf}'>
                                <button type='submit' class='pa-action-link' style='color:#4A6741;'>Restore</button>
                            </form>";
                }

                $id = $category->category_id;
                $name = e($category->category_name);

                return "<div style='display:flex;align-items:center;gap:0;white-space:nowrap;'>
                            <button type='button'
                                class='pa-action-link pa-category-edit'
                                data-category-id='{$id}'
                                data-category-name='{$name}'>
                                Edit
                            </button>
                            <span class='pa-action-sep'></span>
                            <button type='button'
                                class='pa-action-link pa-action-link--danger pa-category-delete'
                                data-category-id='{$id}'
                                data-category-name='{$name}'>
                                Delete
                            </button>
                        </div>";
            })
            ->with('stats', [
                'total' => Category::withTrashed()->count(),
                'active' => Category::withoutTrashed()->count(),
                'archived' => Category::onlyTrashed()->count(),
            ])
            ->rawColumns(['name_col', 'status_col', 'actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|min:2|max:50|unique:categories,category_name',
        ], [
            'category_name.required' => 'Category name is required.',
            'category_name.min' => 'Category name must be at least 2 characters.',
            'category_name.max' => 'Category name cannot exceed 50 characters.',
            'category_name.unique' => 'A category with this name already exists.',
        ]);

        $category = Category::create(['category_name' => $request->category_name]);

        return response()->json(['success' => true, 'category' => $category], 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'category_name' => 'required|string|min:2|max:50|unique:categories,category_name,'.$id.',category_id',
        ], [
            'category_name.required' => 'Category name is required.',
            'category_name.min' => 'Category name must be at least 2 characters.',
            'category_name.max' => 'Category name cannot exceed 50 characters.',
            'category_name.unique' => 'A category with this name already exists.',
        ]);

        $category->update(['category_name' => $request->category_name]);

        return response()->json(['success' => true, 'category' => $category]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => "Cannot delete — {$category->products()->count()} product(s) are still assigned to this category.",
            ], 422);
        }

        $category->delete(); // soft delete

        return response()->json(['success' => true]);
    }

    public function restore($id)
    {
        Category::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.categories.index')->with('success', 'Category restored.');
    }
}
