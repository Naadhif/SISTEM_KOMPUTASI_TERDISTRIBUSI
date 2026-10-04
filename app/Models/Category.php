<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id'];

    // Relasi ke kategori induk
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relasi ke kategori anak
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relasi many-to-many ke produk
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}
