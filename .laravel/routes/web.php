<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home', ["nama" => "capricron", "title" => "Home", "active" => "home"]);
});


// pakai controller

Route::get('/blog', [PostController::class, 'index']);

Route::get('/post/{post:slug}', [PostController::class, 'show']);

Route::get('/categories', function() {
    return view('categories', [
        'title' => "Post Categories",
        'active' => 'categories',    
        'categories' => Category::all()
    ]);
});

Route::get('categories/{category:slug}', function(Category $category){
    return view('posts', [
        'title' => "Post by Category : $category->name",
        'active' => 'categories',
        'posts' => $category->posts->load('category', 'author'),
    ]);
});

Route::get('/author/{author:username}', function(User $author){
    return view('posts', [
        'title' => "Post By Author : $author->name",
        'active' => 'author',
        'posts' => $author->posts->load('category', 'author'),
    ]);
});