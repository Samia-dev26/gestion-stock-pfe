<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 1. رابط باش بنت عمك تجيب كاع السلعة اللي في قاعدة البيانات
Route::get('/products', [ProductController::class, 'index']);

// 2. رابط باش تزيد منتج جديد (الورقة 3.1)
Route::post('/products', [ProductController::class, 'store']);

// 3. رابط باش تسجل خروج أو دخول السلعة (الورقة 3.3)
// {id} هو الرقم ديال المنتج اللي غانبدلو ليه الكمية
Route::post('/products/{id}/update-stock', [ProductController::class, 'updateStock']);