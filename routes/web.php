<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;

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

Route::get('/', [ArticleController::class, 'index']);

Route::group(['prefix' => '/article', 'middleware'=>'auth:sanctum'], function(){
    Route::get('/create', [ArticleController::class, 'create']);
    Route::post('/store', [ArticleController::class, 'store']);
    Route::get('/show/{id}', [ArticleController::class, 'show']);
    Route::get('/edit/{id}', [ArticleController::class, 'edit']);
    Route::post('/update/{id}', [ArticleController::class, 'update']);
    Route::get('/destroy/{id}', [ArticleController::class, 'destroy']);
});

Route::resource('comment', CommentController::class)->middleware('auth:sanctum');

//Route::get('/', [MainController::class, 'index']);
//Route::get('/galery/{full}', [MainController::class, 'show']);
Route::get('/registration', [AuthController::class, 'index']);
Route::post('/registration', [AuthController::class, 'store']);
Route::get('/signin', [AuthController::class, 'login'])->name('login');
Route::post('/signin', [AuthController::class, 'customLogin']);
Route::get('/signout', [AuthController::class, 'signout']);

Route::get('/about', function () {
    return view('main/about');
});

Route::get('/contact', function () {
    $contact = [
        'name' => 'Политех',
        'adres' => 'Пряники',
        'phone' => '8(495)432-2323',
        'email' => '@mospolytech.ru',
    ];
    return view('main/contact', ['contact' => $contact]);
});
