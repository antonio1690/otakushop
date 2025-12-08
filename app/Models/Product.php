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
        'image_url',
        'image_type',  
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

    /**
     * Obtener la URL de la imagen (compatible con Cloudinary y local)
     */
    public function getImageUrl()
    {
        if ($this->image_type === 'url' && $this->image_url) {
            return $this->image_url;
        }
    
        if ($this->image) {
            // Si es una URL completa (Cloudinary), devolverla directamente
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                return $this->image;
            }
            // Si es una ruta local
            return asset('storage/' . $this->image);
        }
    
        return null;
    }

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