<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GestionnaireController;
use App\Http\Controllers\AgentController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 الصفحة الرئيسية (اختيارية)
Route::get('/', function () {
    return view('welcome');
});

// 🧪 ROUTE للتجريب (Test Login)
// دخل لهاد الرابط باش السيستم يفتح ليك Session كـ Admin وتشوف السلعة:
// http://localhost:8000/test-login
Route::get('/test-login', function () {
    $user = User::where('role', 'admin')->first();
    if (!$user) {
        $user = User::create([
            'name' => 'Samia Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
    }
    Auth::login($user);
    return "✅ Vous êtes connecté en tant qu'ADMIN. <a href='/api/products-list'>Voir les produits</a>";
});

// -----------------------------------------------------------------
// 👑 1. مجموعة الـ Admin (التحكم الكامل)
// -----------------------------------------------------------------
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // CRUD Categories
    Route::resource('categories', CategoryController::class);
});

// -----------------------------------------------------------------
// 🧑‍💼 2. مجموعة الـ Gestionnaire (السلعة والمخزون)
// -----------------------------------------------------------------
Route::middleware(['auth', 'role:admin,gestionnaire'])->group(function () {
    Route::get('/gestionnaire/dashboard', [GestionnaireController::class, 'index'])->name('gestionnaire.dashboard');
    
    // مسارات السلعة (القديمة اللي كانت عندك)
    Route::get('/api/products-list', [ProductController::class, 'index']);
    Route::resource('products', ProductController::class);
});

// -----------------------------------------------------------------
// 👨‍🔧 3. مجموعة الـ Agent (الاستعمال فقط)
// -----------------------------------------------------------------
Route::middleware(['auth', 'role:admin,gestionnaire,agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'index'])->name('agent.dashboard');
});

// 🚪 Route ديال الـ Login (غير باش ما يبقاش يطلع ليك Error 500)
Route::get('/login', function () {
    return response()->json(['message' => 'Veuillez vous connecter via l\'API'], 401);
})->name('login');