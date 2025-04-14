<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Créer 50 produits
        \App\Models\Product::factory(50)->create();

        // Créer 20 utilisateurs avec des commandes et des items
        \App\Models\User::factory(20)->create()->each(function ($user) {
            // Chaque utilisateur aura entre 1 et 3 commandes
            \App\Models\Order::factory(rand(1,3))->create([
                'user_id' => $user->id,
            ])->each(function ($order) {
                // Chaque commande aura 1 à 5 items
                \App\Models\OrderItem::factory(rand(1,5))->create([
                    'order_id' => $order->id,
                    // Optionnellement, utiliser un produit existant
                    'product_id' => \App\Models\Product::inRandomOrder()->first()->id,
                    // Vous pourriez recalculer le prix ici si nécessaire
                ]);
            });
        });
    }

}
