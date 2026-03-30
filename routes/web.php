<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GestionnaireController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ProductController;

Route::get('/', function () { return view('welcome'); });

// 👑 ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    Route::post('/admin/users', [AdminController::class, 'storeUser']);
});

// 🧑‍💼 GESTIONNAIRE
Route::middleware(['auth', 'role:admin,gestionnaire'])->group(function () {
    Route::get('/gestionnaire/dashboard', [GestionnaireController::class, 'index']);
    Route::post('/gestionnaire/stock', [GestionnaireController::class, 'storeMouvement']);
    Route::resource('products', ProductController::class);
});

// 👨‍🔧 AGENT
Route::middleware(['auth', 'role:admin,gestionnaire,agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'index']);
    Route::get('/api/products-list', [ProductController::class, 'index']);
});

Route::get('/login', function () { 
    return response()->json(['message' => 'Veuillez vous connecter via l\'API'], 401); 
})->name('login');
Route::get('/debug-backend', function () {
    // 1. كنجيبو كاع السلعة
    $products = App\Models\Product::all();
    
    // 2. كنجيبو آخر حركة تدارت (باش نأكدو التغيير)
    $lastMouvement = App\Models\Mouvement::latest()->first();

    // 3. هاد الدالة هي اللي غتورينا كلشي ناضي
    dd([
        'Message' => 'الـ Backend خدام ناضي!',
        'Liste_des_Produits' => $products->toArray(), // غتلقاي الكميات هنا
        'Dernier_Mouvement' => $lastMouvement ? $lastMouvement->toArray() : 'لا يوجد حركات بعد',
        'Verification_Stock' => 'دخلي لـ phpMyAdmin وزيدي سطر وديري F5 هنا وشوفي الكمية واش تبدلات'
    ]);
});