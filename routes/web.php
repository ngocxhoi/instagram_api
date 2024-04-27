<?php

use App\Http\Controllers\HomeController;
use App\Http\Resources\AllPostCollection;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/all', function () {
    $posts = Post::orderBy('created_at', 'desc')->get();
    return new AllPostCollection($posts);
});

require __DIR__ . '/auth.php';
