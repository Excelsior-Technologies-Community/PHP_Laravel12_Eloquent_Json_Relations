<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

use App\Models\Post;

Route::get('/test', function() {
    // Correct query for integer IDs
    $posts = Post::whereIn('id', [1,2])->get();
    return $posts;
});

Route::get('/', function () {
    return view('welcome');
});
