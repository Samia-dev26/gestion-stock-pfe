<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        return response()->json([
            'role' => 'Agent',
            'message' => 'Consultation du matériel',
            'produits_disponibles' => Product::where('quantity', '>', 0)
                                            ->select('id', 'name', 'description')
                                            ->get(),
            'mes_demandes' => 'Historique des décharges (Bientôt disponible)'
        ]);
    }
}