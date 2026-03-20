<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $initial = $row['initial_price'] ?? ($row['price'] ?? null);
        $selling = $row['selling_price'] ?? ($row['price'] ?? null);

        return new Product([
            'product_name'   => $row['product_name']   ?? '',
            'description'    => $row['description']    ?? null,
            'initial_price'  => $initial,
            'selling_price'  => $selling,
            'stock_quantity' => $row['stock_quantity'] ?? 0,
            'variant'        => $row['variant']        ?? null,
            'is_active'      => isset($row['is_active']) ? (bool) $row['is_active'] : true,
            'category_id'    => $row['category_id']    ?? null,
            'supplier_id'    => $row['supplier_id']    ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            // ── Required ──────────────────────────────────────────
            '*.product_name'    => 'required|string|min:2|max:100',  // varchar(100) in DB
            '*.stock_quantity'  => 'required|integer|min:0',

            // ── Pricing ───────────────────────────────────────────
            '*.initial_price'   => 'nullable|numeric|min:0',
            '*.selling_price'   => 'nullable|numeric|min:0',
            '*.price'           => 'nullable|numeric|min:0',         // legacy fallback

            // ── Optional fields ───────────────────────────────────
            '*.description'     => 'nullable|string|max:2000',
            '*.variant'         => 'nullable|string|max:50',         // varchar(50) in DB
            '*.is_active'       => 'nullable|boolean',
            '*.category_id'     => 'nullable|exists:categories,category_id',
            '*.supplier_id'     => 'nullable|exists:suppliers,supplier_id',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            '*.product_name.required'   => 'Row :position: Product name is required.',
            '*.product_name.max'        => 'Row :position: Product name cannot exceed 100 characters.',
            '*.stock_quantity.required' => 'Row :position: Stock quantity is required.',
            '*.stock_quantity.integer'  => 'Row :position: Stock quantity must be a whole number.',
            '*.stock_quantity.min'      => 'Row :position: Stock quantity cannot be negative.',
            '*.initial_price.numeric'   => 'Row :position: Cost price must be a valid number.',
            '*.initial_price.min'       => 'Row :position: Cost price cannot be negative.',
            '*.selling_price.numeric'   => 'Row :position: Selling price must be a valid number.',
            '*.selling_price.min'       => 'Row :position: Selling price cannot be negative.',
            '*.variant.max'             => 'Row :position: Variant cannot exceed 50 characters.',
            '*.category_id.exists'      => 'Row :position: Category ID does not exist.',
            '*.supplier_id.exists'      => 'Row :position: Supplier ID does not exist.',
        ];
    }
}