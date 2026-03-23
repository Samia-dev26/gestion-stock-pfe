<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // عرض المنتجات والكاتيكوريات
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all(); 
        return view('dashboard', compact('products', 'categories'));
    }

    // إضافة منتج جديد
    public function store(Request $request)
    {
        $data = $request->validate([
            'designation' => 'required',
            'quantite' => 'required|integer',
            'prix' => 'required|numeric',
            'category_id' => 'required|exists:categories,id', //
            'seuil_minimum' => 'nullable|integer' //
        ]);

        Product::create($data);
        return redirect()->route('dashboard')->with('success', 'Produit ajouté !');
    }

    // حذف منتج
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('dashboard');
    }
}