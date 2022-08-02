<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddressController;

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

Route::post('auth/login', [UsersController::class, 'authenticate']);
Route::post('auth/register', [UsersController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('auth/logout', [UsersController::class, 'logout']);

    Route::get('addresses', [AddressController::class, 'index']);
    Route::post('addresses', [AddressController::class, 'store']);
    Route::get('addresses/{id}', [AddressController::class, 'show']);
    Route::put('addresses/{address}',  [AddressController::class, 'update']);
    Route::delete('addresses/{address}',  [AddressController::class, 'destroy']);

});