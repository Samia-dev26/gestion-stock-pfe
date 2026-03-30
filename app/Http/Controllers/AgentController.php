<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AgentController extends Controller {
    public function index() {
        return response()->json([
            'produits' => Product::where('quantity', '>', 0)->get(),
            'message' => 'Interface de consultation'
        ]);
    }
}