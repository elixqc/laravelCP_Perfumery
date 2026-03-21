<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        return view('admin.suppliers.index');
    }

    public function data(Request $request)
    {
        $query = Supplier::withTrashed()
            ->select('supplier_id', 'supplier_name', 'contact_person', 'contact_number', 'address', 'is_active', 'deleted_at');

        return DataTables::of($query)
            ->addColumn('name_col', function (Supplier $supplier) {
                $name = e($supplier->supplier_name);

                return "<span class='u-name' style='font-style:italic;'>{$name}</span>";
            })
            ->addColumn('contact_person_col', function (Supplier $supplier) {
                $person = e($supplier->contact_person ?? '—');
                $empty = !$supplier->contact_person;

                return "<span class='u-name' style='font-weight:300;".($empty ? 'color:#B0A898;' : '')."'>{$person}</span>";
            })
            ->addColumn('contact_number_col', function (Supplier $supplier) {
                $number = e($supplier->contact_number ?? '—');
                $empty = !$supplier->contact_number;

                return "<span class='u-email' style='text-decoration:none;border:none;".($empty ? 'color:#B0A898;' : '')."'>{$number}</span>";
            })
            ->addColumn('address_col', function (Supplier $supplier) {
                $address = e($supplier->address ?? '—');
                $empty = !$supplier->address;

                return "<span style='font-family:Jost,sans-serif;font-size:0.82rem;font-weight:300;".($empty ? 'color:#B0A898;' : 'color:#5A524A;')."'>{$address}</span>";
            })
            ->addColumn('status_col', function (Supplier $supplier) {
                $html = "<div style='display:flex;flex-wrap:wrap;gap:0.4rem;align-items:center;'>";

                $activeCls = $supplier->is_active ? 'pa-status pa-status--success' : 'pa-status pa-status--danger';
                $activeLabel = $supplier->is_active ? 'Active' : 'Inactive';
                $html .= "<span class='{$activeCls}'>{$activeLabel}</span>";

                if ($supplier->trashed()) {
                    $html .= "<span class='pa-status pa-status--danger'>Archived</span>";
                }

                return $html.'</div>';
            })
            ->addColumn('actions', function (Supplier $supplier) {
                // Trashed — Restore only
                if ($supplier->trashed()) {
                    $restoreUrl = route('admin.suppliers.restore', $supplier->supplier_id);
                    $csrf = csrf_token();

                    return "<form method='POST' action='{$restoreUrl}' style='display:inline;'>
                                <input type='hidden' name='_token' value='{$csrf}'>
                                <button type='submit' class='pa-action-link' style='color:#4A6741;'>Restore</button>
                            </form>";
                }

                // Active
                $editUrl = route('admin.suppliers.edit', $supplier->supplier_id);
                $supplierId = $supplier->supplier_id;
                $supplierName = e($supplier->supplier_name);

                return "<div style='display:flex;align-items:center;gap:0;white-space:nowrap;'>
                            <a href='{$editUrl}' class='pa-action-link'>Edit</a>
                            <span class='pa-action-sep'></span>
                            <button type='button'
                                class='pa-action-link pa-action-link--danger pa-supplier-delete'
                                data-supplier-id='{$supplierId}'
                                data-supplier-name='{$supplierName}'>
                                Delete
                            </button>
                        </div>";
            })
            ->with('stats', [
                'total' => Supplier::withTrashed()->count(),
                'active' => Supplier::withoutTrashed()->where('is_active', true)->count(),
                'inactive' => Supplier::withoutTrashed()->where('is_active', false)->count(),
            ])
            ->rawColumns(['name_col', 'contact_person_col', 'contact_number_col', 'address_col', 'status_col', 'actions'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|string|min:2|max:255|unique:suppliers,supplier_name',
            'contact_person' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ], [
            'supplier_name.required' => 'Company name is required.',
            'supplier_name.min' => 'Company name must be at least 2 characters.',
            'supplier_name.max' => 'Company name cannot exceed 255 characters.',
            'supplier_name.unique' => 'A supplier with this name already exists.',
            'contact_person.max' => 'Contact person cannot exceed 255 characters.',
            'contact_number.max' => 'Contact number cannot exceed 50 characters.',
            'address.max' => 'Address cannot exceed 500 characters.',
        ]);

        Supplier::create([
            'supplier_name' => $request->supplier_name,
            'contact_person' => $request->contact_person,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier created.');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'supplier_name' => 'required|string|min:2|max:255|unique:suppliers,supplier_name,'.$id.',supplier_id',
            'contact_person' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ], [
            'supplier_name.required' => 'Company name is required.',
            'supplier_name.min' => 'Company name must be at least 2 characters.',
            'supplier_name.max' => 'Company name cannot exceed 255 characters.',
            'supplier_name.unique' => 'A supplier with this name already exists.',
            'contact_person.max' => 'Contact person cannot exceed 255 characters.',
            'contact_number.max' => 'Contact number cannot exceed 50 characters.',
            'address.max' => 'Address cannot exceed 500 characters.',
        ]);

        $supplier->update([
            'supplier_name' => $request->supplier_name,
            'contact_person' => $request->contact_person,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated.');
    }

    /**
     * Soft-delete — called via axios.delete() from the modal.
     * Returns JSON so the blade toast fires correctly.
     */
    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete(); // soft delete via SoftDeletes trait

        return response()->json([
            'success' => true,
            'message' => 'Supplier archived successfully.',
        ]);
    }

    /**
     * Restore a soft-deleted supplier.
     */
    public function restore($id)
    {
        Supplier::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier restored.');
    }
}
