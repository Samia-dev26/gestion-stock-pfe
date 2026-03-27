<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class GestionnaireController extends Controller
{
    public function index()
    {
        return response()->json([
            'role' => 'Gestionnaire',
            'stats' => [
                'total_produits' => Product::count(),
                'stock_faible' => Product::where('quantity', '<', 5)->count(),
            ],
            'actions_autorisees' => [
                'inventory' => 'Consulter et Modifier Stock',
                'products' => 'Ajouter et Modifier Produits',
                'users' => 'Accès Refusé'
            ],
            'inventory_list' => Product::select('id', 'name', 'quantity', 'min_stock')->get()
        ]);
    }
}