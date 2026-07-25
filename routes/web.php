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
    Route::get('/users', [App\Http\Controllers\UserController::class, 'users'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');
    Route::get('/subir-imagen', [App\Http\Controllers\ImageController::class, 'create'])->name('images.create');
    Route::get('/imagenes', [App\Http\Controllers\ImageController::class, 'index'])->name('images.index');
    Route::get('/imagen/{image}', [App\Http\Controllers\ImageController::class, 'show'])->name('images.show');
    Route::get('/image/edit/{image}', [App\Http\Controllers\ImageController::class, 'edit'])->name('images.edit');
    Route::patch('/image/update/{image}', [App\Http\Controllers\ImageController::class, 'update'])->name('images.update');
    Route::post('/image/store', [App\Http\Controllers\ImageController::class, 'store'])->name('images.store');
    Route::delete('/image/delete/{image}', [App\Http\Controllers\ImageController::class, 'delete'])->name('images.delete');
    Route::post('/comments/store', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'delete'])->name('comments.delete');

    // Likes routes
    Route::get('/likes', [App\Http\Controllers\LikeController::class, 'index'])->name('likes.index');
    Route::post('/like/{image}', [App\Http\Controllers\LikeController::class, 'like'])->name('like');
    Route::post('/dislike/{image}', [App\Http\Controllers\LikeController::class, 'dislike'])->name('dislike');
});


require __DIR__.'/auth.php';
