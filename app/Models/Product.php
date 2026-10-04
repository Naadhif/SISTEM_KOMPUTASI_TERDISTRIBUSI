<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['seller_id', 'name', 'description', 'price', 'stock', 'image'];

    // Relasi ke seller (user)
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // Relasi many-to-many ke kategori
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    // Relasi ke order_details
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
