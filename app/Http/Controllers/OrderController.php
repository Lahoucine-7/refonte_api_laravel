<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Lister toutes les commandes
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    // Créer une nouvelle commande
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status'  => 'required|string',
            'total'   => 'required|numeric|min:0',
        ]);

        $order = Order::create($request->all());
        return response()->json($order, 201);
    }

    // Afficher une commande particulière
    public function show($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Commande non trouvée'], 404);
        }
        return response()->json($order);
    }

    // Mettre à jour une commande existante
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Commande non trouvée'], 404);
        }

        $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'status'  => 'sometimes|required|string',
            'total'   => 'sometimes|required|numeric|min:0',
        ]);

        $order->update($request->all());
        return response()->json($order);
    }

    // Supprimer une commande
    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Commande non trouvée'], 404);
        }

        $order->delete();
        return response()->json(['message' => 'Commande supprimée']);
    }
}
