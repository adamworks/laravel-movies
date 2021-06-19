<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OtpController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function() {
	Route::post('register', [AuthController::class, 'register'])->name('api.user.register');
	Route::post('register-with-sosmed', [AuthController::class, 'registerSosmed'])->name('api.user.register.with.sosmed');
    Route::post('login', [AuthController::class, 'login'])->name('api.user.login');
	Route::post('login-with-sosmed', [AuthController::class, 'loginSosmed'])->name('api.user.login.with.sosmed');
    
	Route::post('otp-verification', [OtpController::class, 'verification'])->name('api.user.otp.verification');
	Route::post('otp-resend', [OtpController::class, 'resend'])->name('api.user.otp.resend');
    
	// Route::middleware('auth:api')->get('/user', function (Request $request) {
    //     return $request->user();
    // });
});

Route::group(['prefix'=> 'user','middleware' => 'api.auth.basic'], function() {
	//user
	Route::get('',[UserController::class, 'view'])->name('api.user.view');
	Route::put('update',[UserController::class, 'update'])->name('api.users.update');

	//detail
	Route::get('detail/{detail_id}', [UserController::class, 'detailView'])->name('api.users.detail.view');
	Route::post('detail', [UserController::class, 'detailStore'])->name('api.users.detail.store');
	Route::put('detail/update/{detail_id}',[UserController::class, 'detailUpdate'])->name('api.users.detail.update');
	Route::delete('detail/delete/{detail_id}', [UserController::class, 'detailDestroy'])->name('api.users.detail.destroy');
});

