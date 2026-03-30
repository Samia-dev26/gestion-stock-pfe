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
});