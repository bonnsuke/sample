<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('/welcome');
});
// product-list
// product-home
// product-registration
// product-edit


Route::get('/dashboard', function () {
    return view('/home');
})->middleware(['auth', 'verified'])->name('dashboard');

// 一覧画面へ
Route::get('/dashboard', [ProductController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');

// 商品登録画面へ
Route::get('/registration', [App\Http\Controllers\ProductController::class, 'create']);
// 種別登録画面
Route::get('/type', [App\Http\Controllers\TypeController::class, 'create']);
// 商品一覧画面へ
Route::get('/list', [App\Http\Controllers\ProductController::class, 'index']);
// home画面へ
Route::get('/home', [App\Http\Controllers\ProductController::class, 'show']);
// 編集画面へ
Route::get('/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit']);
// 商品登録へ
// Route::POST('/product_regis', [App\Http\Controllers\ProductController::class, 'store']);
// 編集登録
Route::post('/edit_complete', [App\Http\Controllers\ProductController::class, 'update']);
// 編集削除
Route::post('/delete', [App\Http\Controllers\ProductController::class, 'destroy']);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';


// 管理者以上
Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
    Route::post('/product_regis', [App\Http\Controllers\ProductController::class, 'store']);
    Route::post('/product_type', [App\Http\Controllers\TypeController::class, 'store']);
    Route::delete('/delete', [App\Http\Controllers\ProductController::class, 'destroy']);

});