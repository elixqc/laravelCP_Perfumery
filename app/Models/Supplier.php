<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $table = 'suppliers';
    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'supplier_name',
        'contact_person',
        'contact_number',
        'address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'supplier_id');
    }

    public function supplyLogs()
    {
        return $this->hasMany(SupplyLog::class, 'supplier_id');
    }
}
