<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'supply_logs';
    protected $primaryKey = 'supply_id';

    protected $fillable = [
        'product_id',
        'supplier_id',
        'quantity_added',
        'supplier_price',
        'supply_date',
        'remarks',
    ];

    protected $casts = [
        'supply_date' => 'datetime',
        'supplier_price' => 'decimal:2',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}