<?php

use App\Http\Controllers\BuyersController;
use App\Http\Controllers\SellersController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::resource('buyers', BuyersController::class)->only('index', 'show');
Route::resource('sellers', SellersController::class)->only('index', 'show');
Route::resource('users', UsersController::class)->except('create,edit');
