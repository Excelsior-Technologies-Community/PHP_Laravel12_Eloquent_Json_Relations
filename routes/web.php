<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Http\Controllers\UserPostController;

// Test route (simple check)
Route::get('/test', function() {
    return Post::whereIn('id', [1,2])->get();
});

// Home
Route::get('/', function () {
    return view('welcome');
});

// Users + JSON relation UI
Route::get('/users', [UserPostController::class, 'index']);
Route::get('/users/{id}/add-post', [UserPostController::class, 'create']);
Route::post('/users/{id}/add-post', [UserPostController::class, 'store']);
Route::get('/users/{userId}/remove/{postId}', [UserPostController::class, 'remove']);