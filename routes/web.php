<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Http\Controllers\UserPostController;

Route::get('/test', function() {
    return Post::whereIn('id',)->get();
});

Route::get('/', function () {
    return view('welcome');
});

// Users Routes
Route::get('/users', [UserPostController::class, 'index']);
Route::get('/users/{id}/add-post', [UserPostController::class, 'create']);
Route::post('/users/{id}/add-post', [UserPostController::class, 'store']);
Route::get('/users/{userId}/remove/{postId}', [UserPostController::class, 'remove']);

// Dashboard Route
Route::get('/dashboard', function () {
    return view('dashboard');
});