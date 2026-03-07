<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    public $timestamps = false;

    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'description',
        'initial_price',
        'selling_price',
        'stock_quantity',
        'image_path',
        'variant',
        'is_active',
        'category_id',
        'supplier_id',
    ];

    protected $casts = [
        'initial_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }

    public function supplyLogs()
    {
        return $this->hasMany(SupplyLog::class, 'product_id');
    }

    public function cartUsers()
    {
        return $this->belongsToMany(User::class, 'cart', 'product_id', 'user_id')->withPivot('quantity', 'date_added');
    }

    // Accessors
    public function getNameAttribute()
    {
        // allow convenience $product->name in templates
        return $this->product_name;
    }

    public function getTotalStockAttribute()
    {
        return $this->supplyLogs()->sum('quantity_added') - $this->orderDetails()->sum('quantity');
    }
}