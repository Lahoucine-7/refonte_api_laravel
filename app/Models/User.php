<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les attributs qui sont assignables en masse.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Les attributs à masquer pour les tableaux.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les casts d'attributs.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relations : Un utilisateur peut avoir plusieurs commandes.
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
