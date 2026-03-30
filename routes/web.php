<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\DechargeController;
use App\Http\Controllers\InventaireController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;


// هادشي بوحدو اللي خاصو يبقى باش تشوفي الـ Front-end بلا Error
/*Route::get('/login', function () {
    return view('auth.login'); 
})->name('login');

Route::get('/register', function () {
    return view('auth.register'); 
})->name('register');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// هادا هو السطر اللي كيقبل الطلب ديال زرار Login
Route::post('/login', function (Request $request) {
    // بما أنك باغية غير تشوفي الـ Dashboard، غانقولو ليه صيفطنا نيشان بلا ما تقلب فـ الداتابيز
    return redirect()->route('admin.dashboard'); 
});*/
// ومن بعد كيبدا الـ middleware...



Route::get('/', function () {
    return redirect()->route('register');
});

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
=======
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
>>>>>>> 11bbebcd6d533c1a2f3304d47e89c82d050ab9c5
});