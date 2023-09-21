<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', [ProductController::class,'index'])->name('products');

Route::middleware(['auth','active'])->group(function () {

    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/users', [UsersController::class,'index'])->name('users');
    Route::get('/users/cancel/{user}', [UsersController::class,'cancel'])->name('user.cancel');
    Route::get('/users/grant/{user}', [UsersController::class,'grant'])->name('user.grant');
    Route::post('/checkout/{product}', [ProductController::class,'checkout'])->name('checkout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/success', [ProductController::class,'success'])->name('checkout.success');
    Route::get('/cancel', [ProductController::class,'cancel'])->name('checkout.cancel');
});

require __DIR__.'/auth.php';
