<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Attributs assignables en masse
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // Relation : Un item appartient à une commande
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relation : Un item fait référence à un produit
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
