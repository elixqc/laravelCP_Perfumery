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
        $query = Supplier::select('supplier_id', 'supplier_name', 'contact_person', 'contact_number', 'address', 'is_active');

        return DataTables::of($query)
            ->addColumn('name_col', function (Supplier $supplier) {
                $name = e($supplier->supplier_name);
                return "<span style=\"font-family:'Cormorant Garamond',serif; font-size:1.05rem; font-weight:300; color:#1A1714; letter-spacing:0.03em; font-style:italic;\">{$name}</span>";
            })
            ->addColumn('contact_person_col', function (Supplier $supplier) {
                $person = e($supplier->contact_person ?? '—');
                return "<span style=\"font-size:0.92rem; color:#2C2825; font-family:'Jost',sans-serif; font-weight:400;\">{$person}</span>";
            })
            ->addColumn('contact_number_col', function (Supplier $supplier) {
                $number = e($supplier->contact_number ?? '—');
                return "<span style=\"font-size:0.88rem; color:#5A524A; font-family:'Jost',sans-serif; font-weight:300;\">{$number}</span>";
            })
            ->addColumn('actions', function (Supplier $supplier) {
                $csrf      = csrf_token();
                $editUrl   = route('admin.suppliers.edit', $supplier->supplier_id);
                $deleteUrl = route('admin.suppliers.destroy', $supplier->supplier_id);

                return "<div style='display:flex; align-items:center; gap:1rem; white-space:nowrap;'>
                            <a href='{$editUrl}'
                            style=\"font-family:'Jost',sans-serif; font-size:0.78rem; font-weight:400; letter-spacing:0.08em; color:#2C2825; text-decoration:none; border-bottom:1px solid transparent; padding-bottom:1px;\"
                            onmouseover=\"this.style.color='#B5975A'; this.style.borderBottomColor='#B5975A'\"
                            onmouseout=\"this.style.color='#2C2825'; this.style.borderBottomColor='transparent'\">Edit</a>
                            <span style='color:#D6D0C8; font-size:0.7rem;'>|</span>
                            <form method='POST' action='{$deleteUrl}' style='display:inline;'
                                onsubmit=\"return confirm('Delete this supplier? This cannot be undone.')\">
                                <input type='hidden' name='_token' value='{$csrf}'>
                                <input type='hidden' name='_method' value='DELETE'>
                                <button type='submit'
                                        style='background:none; border:none; cursor:pointer; font-family:Jost,sans-serif; font-size:0.78rem; font-weight:400; letter-spacing:0.08em; color:#8B3A3A; padding:0;'
                                        onmouseover=\"this.style.color='#C97A7A'\"
                                        onmouseout=\"this.style.color='#8B3A3A'\">Delete</button>
                            </form>
                        </div>";
            })
            ->with('stats', ['total' => Supplier::count()])
            ->rawColumns(['name_col', 'contact_person_col', 'contact_number_col', 'actions'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_name'  => 'required|string|min:2|max:255|unique:suppliers,supplier_name',
            'contact_person' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'address'        => 'nullable|string|max:500',
            'is_active'      => 'nullable|boolean',
        ], [
            'supplier_name.required' => 'Company name is required.',
            'supplier_name.min'      => 'Company name must be at least 2 characters.',
            'supplier_name.max'      => 'Company name cannot exceed 255 characters.',
            'supplier_name.unique'   => 'A supplier with this name already exists.',
            'contact_person.max'     => 'Contact person cannot exceed 255 characters.',
            'contact_number.max'     => 'Contact number cannot exceed 50 characters.',
            'address.max'            => 'Address cannot exceed 500 characters.',
        ]);

        Supplier::create([
            'supplier_name'  => $request->supplier_name,
            'contact_person' => $request->contact_person,
            'contact_number' => $request->contact_number,
            'address'        => $request->address,
            'is_active'      => $request->boolean('is_active'),
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
            'supplier_name'  => 'required|string|min:2|max:255|unique:suppliers,supplier_name,' . $id . ',supplier_id',
            'contact_person' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'address'        => 'nullable|string|max:500',
            'is_active'      => 'nullable|boolean',
        ], [
            'supplier_name.required' => 'Company name is required.',
            'supplier_name.min'      => 'Company name must be at least 2 characters.',
            'supplier_name.max'      => 'Company name cannot exceed 255 characters.',
            'supplier_name.unique'   => 'A supplier with this name already exists.',
            'contact_person.max'     => 'Contact person cannot exceed 255 characters.',
            'contact_number.max'     => 'Contact number cannot exceed 50 characters.',
            'address.max'            => 'Address cannot exceed 500 characters.',
        ]);

        $supplier->update([
            'supplier_name'  => $request->supplier_name,
            'contact_person' => $request->contact_person,
            'contact_number' => $request->contact_number,
            'address'        => $request->address,
            'is_active'      => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated.');
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted.');
    }
}