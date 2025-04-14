<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Attributs assignables en masse
    protected $fillable = ['user_id', 'status', 'total'];

    // Relation : Une commande appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation : Une commande contient plusieurs items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
