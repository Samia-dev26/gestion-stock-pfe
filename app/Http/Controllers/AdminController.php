<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json([
            'role' => 'Admin',
            'stats' => [
                'total_produits' => Product::count(),
                'total_users' => User::count(),
                'stock_faible' => Product::where('quantity', '<', 5)->count(),
                'valeur_stock' => Product::sum(DB::raw('price * quantity')),
            ],
            // هاد الجزء غيعمر ملي نزيدو جدول Mouvements
            'recent_activity' => [
                'latest_products' => Product::latest()->take(5)->get(),
            ],
            'permissions' => 'Full Access (CRUD Users, Products, Categories, Reports)'
        ]);
    }
}