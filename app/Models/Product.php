<?php

// app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category_id',
        'franchise_id',
        'is_preorder',
        'release_date',
        'featured'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_preorder' => 'boolean',
        'featured' => 'boolean',
        'release_date' => 'date'
    ];

    // Relaciones
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Métodos auxiliares
    public function isAvailable()
    {
        return $this->stock > 0 || $this->is_preorder;
    }
}
