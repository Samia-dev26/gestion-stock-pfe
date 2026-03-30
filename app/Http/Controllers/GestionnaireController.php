<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Mouvement;
use Illuminate\Http\Request;

class GestionnaireController extends Controller {
    public function index() {
        return response()->json([
            'stats' => [
                'produits' => Product::count(),
                'stock_faible' => Product::where('quantity', '<', 5)->count(),
            ],
            'inventory' => Product::all()
        ]);
    }

    public function storeMouvement(Request $request) {
        $product = Product::findOrFail($request->product_id);
        Mouvement::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'type' => $request->type,
            'quantite' => $request->quantite,
        ]);

        if($request->type == 'entree') $product->increment('quantity', $request->quantite);
        else $product->decrement('quantity', $request->quantite);

        return response()->json(['message' => 'Stock mis à jour!']);
    }
}