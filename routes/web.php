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



Route::get('/', function () {
    return redirect()->route('register');
});

// Legacy login - use auth views
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Register disabled (missing controller) - use /test-login
// Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');

Route::middleware(['auth'])->group(function () {

    // Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    Route::get('/gestionnaire/dashboard', function () {
        return view('gestionnaire.dashboard');
    })->middleware('role:gestionnaire,admin')->name('gestionnaire.dashboard');

    Route::get('/agent/dashboard', function () {
        return view('agent.dashboard');
    })->middleware('role:agent,gestionnaire,admin')->name('agent.dashboard');

    // Articles
    Route::resource('articles', ArticleController::class);
    Route::get('/articles-export', [ArticleController::class, 'export'])->name('articles.export');

    // Catégories
    Route::resource('categories', CategorieController::class);

    // Mouvements
    Route::resource('mouvements', MouvementController::class)->only(['index', 'create', 'store', 'show']);

    // Décharges
    Route::resource('decharges', DechargeController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('/decharges/{decharge}/pdf', [DechargeController::class, 'pdf'])->name('decharges.pdf');

    // Notifications
    Route::get('/notifications', function () {
        return view('notifications.index');
    })->name('notifications.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Gestionnaire + Admin
    Route::middleware('role:admin,gestionnaire')->group(function () {
        Route::resource('inventaires', InventaireController::class);
        Route::post('/inventaires/{inventaire}/valider', [InventaireController::class, 'valider'])->name('inventaires.valider');
        Route::resource('fournisseurs', FournisseurController::class);
        Route::get('/rapports', [RapportController::class, 'index'])->name('rapports.index');
        Route::get('/rapports/stock', [RapportController::class, 'stockActuel'])->name('rapports.stock');
        Route::get('/rapports/historique', [RapportController::class, 'historique'])->name('rapports.historique');
    });

    // Admin seulement
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/toggle', [UserController::class, 'toggleActive'])->name('users.toggle');
        Route::resource('roles', RoleController::class);
        Route::get('/logs', function () {
            return view('logs.index');
        })->name('logs.index');
    });
});


