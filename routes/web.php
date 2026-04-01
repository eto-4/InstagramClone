<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// ImageController Routes
Route::get('/images/{image}', [ImageController::class, 'show'])->name('images.show');

Route::get('/images/{image}/data', [ImageController::class, 'data'])->name('images.data');

Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // CommentCobtroller Routes
    Route::post('/images/{image}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // LikeController Routes
    Route::post('/images/{image}/like', [LikeController::class, 'toggle'])->name('likes.toggle');
    
    // Posts CRUD Routes
    Route::get('/posts/create', [ImageController::class, 'create'])->name('posts.create');
    Route::post('/posts', [ImageController::class, 'store'])->name('posts.store');
    Route::get('/posts/{image}/edit', [ImageController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/{image}', [ImageController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{image}', [ImageController::class, 'destroy'])->name('posts.destroy');    
});
    
require __DIR__.'/auth.php';