<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Attributs assignables en masse
    protected $fillable = ['name', 'description', 'price', 'stock'];

    // Relation : Un produit peut être associé à plusieurs lignes de commande
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
