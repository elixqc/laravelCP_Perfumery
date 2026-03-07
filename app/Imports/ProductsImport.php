<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // If only 'price' is provided, use it for both fields
        $initial = $row['initial_price'] ?? ($row['price'] ?? null);
        $selling = $row['selling_price'] ?? ($row['price'] ?? null);
        return new Product([
            'product_name'    => $row['product_name'] ?? '',
            'description'     => $row['description'] ?? '',
            'initial_price'   => $initial,
            'selling_price'   => $selling,
            'stock_quantity'  => $row['stock_quantity'] ?? 0,
            'variant'         => $row['variant'] ?? null,
            'is_active'       => isset($row['is_active']) ? (bool)$row['is_active'] : true,
            'category_id'     => $row['category_id'] ?? null,
            'supplier_id'     => $row['supplier_id'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.product_name'    => 'required',
            '*.initial_price'   => 'nullable|numeric',
            '*.selling_price'   => 'nullable|numeric',
            '*.price'           => 'nullable|numeric', // legacy/compatibility, not stored
            '*.stock_quantity'  => 'required|integer',
            '*.category_id'     => 'nullable|exists:categories,category_id',
            '*.supplier_id'     => 'nullable|exists:suppliers,supplier_id',
        ];
    }
}
