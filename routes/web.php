<?php

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
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
    $article = Article::paginate(2);
    return view('blog', compact('article'));
})->name('blog');

Auth::routes();

Route::get('/blog/detail/{id}', function ($id) {
    $data['id'] = $id;
    $detail_artikels = Article::where('id', $id)->get();
    $comment = Comment::where('article_id', $id)->get();
    return view('blog-detail', $data, compact('detail_artikels', 'comment'));
});

Route::middleware(['auth', 'user-access:2'])->group(function () {
    // comment
    Route::post('/comment/{id}', 'App\Http\Controllers\CommentController@store');
    Route::get('/edit-comment', 'App\Http\Controllers\CommentController@edit');
    Route::post('/update-comment', 'App\Http\Controllers\CommentController@update');
    Route::get('/hapus-comment', 'App\Http\Controllers\CommentController@delete');
    Route::post('/destroy-comment', 'App\Http\Controllers\CommentController@destroy');
});

Route::middleware(['auth', 'user-access:1'])->group(function () {
    Route::get('/home', [App\Http\Controllers\AdminController::class, 'index'])->name('home');
    // article
    Route::post('/add-article/save', 'App\Http\Controllers\ArticleController@store');
    Route::get('/edit-article', 'App\Http\Controllers\ArticleController@edit');
    Route::post('/update-article', 'App\Http\Controllers\ArticleController@update');
    Route::get('/hapus-article', 'App\Http\Controllers\ArticleController@delete');
    Route::post('/destroy-article', 'App\Http\Controllers\ArticleController@destroy');
    Route::get('/lihat_content', 'App\Http\Controllers\ArticleController@lihat');
});