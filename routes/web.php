<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/configuracion', [App\Http\Controllers\UserController::class, 'config'])->name('user.config');
    Route::patch('/user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::get('/user/avatar/{filename}', [App\Http\Controllers\UserController::class, 'getImage'])->name('user.avatar');
    Route::get('/subir-imagen', [App\Http\Controllers\ImageController::class, 'create'])->name('images.create');
    Route::get('/imagenes', [App\Http\Controllers\ImageController::class, 'index'])->name('images.index');
    Route::get('/imagen/{image}', [App\Http\Controllers\ImageController::class, 'show'])->name('images.show');
    Route::post('/image/store', [App\Http\Controllers\ImageController::class, 'store'])->name('images.store');
    Route::post('/comments/store', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
});


require __DIR__.'/auth.php';
