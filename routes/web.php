<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
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

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{post}', [HomeController::class, 'show'])->name('post');

Route::resource('/posts', PostController::class);



//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');