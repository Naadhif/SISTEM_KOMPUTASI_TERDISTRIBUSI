<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'status', 'total'];

    // Relasi ke user (pembeli)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke order details
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Helper untuk mendapatkan total dari sum order_details
    public function calculateTotal()
    {
        return $this->details()->sum('subtotal');
    }
}
