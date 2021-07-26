<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

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
    return view('welcome');
});

Route::get('/movies/{page?}', [MovieController::class, 'index'])->name('movie.index');
Route::get('/login-web', [AuthController::class, 'loginWeb'])->name('web.user.login');
Route::post('/login-web', [AuthController::class, 'loginWebAuth'])->name('web.user.login');
	