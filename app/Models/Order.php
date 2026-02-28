<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'order_date',
        'order_status',
        'date_received',
        'delivery_address',
        'payment_method',
        'payment_reference',
        'total_amount',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    // Accessor for calculated total
    public function getCalculatedTotalAttribute()
    {
        return $this->orderDetails->sum(function ($detail) {
            return $detail->quantity * $detail->unit_price;
        });
    }
}