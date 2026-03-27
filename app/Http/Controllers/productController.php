<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {
    // GET: جلب المنتجات مع أصنافها (طلب المؤطر)
    public function index() {
        $products = Product::with('category')->get();
        return response()->json($products);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id'
        ]);
        Product::create($validated);
        return response()->json(['message' => 'Produit ajouté avec succès']);
    }

    public function show(Product $product) {
        return response()->json($product->load('category'));
    }

    public function destroy(Product $product) {
        $product->delete();
        return response()->json(['message' => 'Produit supprimé']);
    }
}