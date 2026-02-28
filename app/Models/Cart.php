<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'cart';
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'date_added',
    ];

    protected $casts = [
        'date_added' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}