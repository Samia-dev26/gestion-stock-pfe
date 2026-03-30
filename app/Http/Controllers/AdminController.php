<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Mouvement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {
    public function index() {
        return response()->json([
            'stats' => [
                'total_produits' => Product::count(),
                'total_users' => User::count(),
                'stock_faible' => Product::where('quantity', '<', 5)->count(),
                'mouvements_aujourdhui' => Mouvement::whereDate('created_at', today())->count(),
            ],
            'users' => User::all(),
            'products' => Product::with('category')->get()
        ]);
    }

    public function storeUser(Request $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);
        return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user]);
    }
}