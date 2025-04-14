<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    // Lister toutes les lignes de commande
    public function index()
    {
        $orderItems = OrderItem::all();
        return response()->json($orderItems);
    }

    // Créer une nouvelle ligne de commande
    public function store(Request $request)
    {
        $request->validate([
            'order_id'   => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'price'      => 'required|numeric|min:0',
        ]);

        $orderItem = OrderItem::create($request->all());
        return response()->json($orderItem, 201);
    }

    // Afficher une ligne de commande spécifique
    public function show($id)
    {
        $orderItem = OrderItem::find($id);
        if (!$orderItem) {
            return response()->json(['message' => 'Ligne de commande non trouvée'], 404);
        }
        return response()->json($orderItem);
    }

    // Mettre à jour une ligne de commande existante
    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::find($id);
        if (!$orderItem) {
            return response()->json(['message' => 'Ligne de commande non trouvée'], 404);
        }

        $request->validate([
            'order_id'   => 'sometimes|required|exists:orders,id',
            'product_id' => 'sometimes|required|exists:products,id',
            'quantity'   => 'sometimes|required|integer|min:1',
            'price'      => 'sometimes|required|numeric|min:0',
        ]);

        $orderItem->update($request->all());
        return response()->json($orderItem);
    }

    // Supprimer une ligne de commande
    public function destroy($id)
    {
        $orderItem = OrderItem::find($id);
        if (!$orderItem) {
            return response()->json(['message' => 'Ligne de commande non trouvée'], 404);
        }

        $orderItem->delete();
        return response()->json(['message' => 'Ligne de commande supprimée']);
    }
}
