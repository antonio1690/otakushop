<?php

// app/Models/Franchise.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Franchise extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'logo'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}