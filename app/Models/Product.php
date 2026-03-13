<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes, Searchable;

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

    // ── Relationships ────────────────────────────────────────────

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
        return $this->belongsToMany(User::class, 'cart', 'product_id', 'user_id')
                    ->withPivot('quantity', 'date_added');
    }

    // ── Accessors ────────────────────────────────────────────────

    public function getNameAttribute()
    {
        return $this->product_name;
    }

    // ── Query Scopes ─────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeSearch($query, $search = null)
    {
        if (!$search) return $query;

        return $query->where(function ($q) use ($search) {
            $q->where('product_name', 'LIKE', '%' . $search . '%')
              ->orWhere('description', 'LIKE', '%' . $search . '%');
        });
    }

    public function scopeByCategory($query, $categoryId = null)
    {
        if (!$categoryId) return $query;
        return $query->where('category_id', $categoryId);
    }

    public function scopeBySupplier($query, $supplierId = null)
    {
        if (!$supplierId) return $query;
        return $query->where('supplier_id', $supplierId);
    }

    public function scopeSortByPrice($query, $direction = null)
    {
        return match ($direction) {
            'asc'  => $query->orderBy('selling_price', 'asc'),
            'desc' => $query->orderBy('selling_price', 'desc'),
            default => $query->orderBy('product_id', 'desc'),
        };
    }

    public function getTotalStockAttribute()
    {
        return $this->supplyLogs()->sum('quantity_added')
             - $this->orderDetails()->sum('quantity');
    }

    // ── Laravel Scout ────────────────────────────────────────────

    public function toSearchableArray()
    {
        return [
            'product_id'   => $this->product_id,
            'product_name' => $this->product_name,
            'description'  => $this->description,
            'selling_price'=> $this->selling_price,
            'category_id'  => $this->category_id,   // needed for category filter
            'is_active'    => $this->is_active,
        ];
    }

    public function getScoutKey()
    {
        return $this->product_id;
    }

    public function getScoutKeyName()
    {
        return 'product_id';
    }

    public function shouldBeSearchable()
    {
        return $this->is_active;
    }
}