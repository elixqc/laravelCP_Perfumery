<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public $timestamps = false;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'full_name',
        'email',
        'password',
        'role',
        'contact_number',
        'address',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_registered' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class, 'user_id');
    }

    public function cartItems()
    {
        return $this->belongsToMany(Product::class, 'cart', 'user_id', 'product_id')->withPivot('quantity', 'date_added');
    }

    // Accessors
    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }

    public function getIsCustomerAttribute()
    {
        return $this->role === 'customer';
    }
}
