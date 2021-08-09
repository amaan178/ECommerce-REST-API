<?php

use App\Http\Controllers\BuyerCategoryController;
use App\Http\Controllers\BuyerProductController;
use App\Http\Controllers\BuyersController;
use App\Http\Controllers\BuyerSellerController;
use App\Http\Controllers\BuyerTransactionController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SellersController;
use App\Http\Controllers\TransactinCategoryController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\TransactionSellerController;
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

//Route::resource('buyers', BuyersController::class, ['only' => ['index', 'show']]);
Route::resource('buyers', BuyersController::class)->only('index', 'show');
Route::resource('categories', CategoriesController::class)->except('create,edit');
Route::resource('sellers', SellersController::class)->only('index', 'show');
Route::resource('users', UsersController::class)->except('create,edit');
Route::resource('products', ProductsController::class)->only('index', 'show');
Route::resource('transactions', TransactionsController::class)->only('index', 'show');

Route::resource('transactions.categories', TransactinCategoryController::class)->only('index');
Route::resource('transactions.sellers', TransactionSellerController::class)->only('index');
Route::resource('buyers.transactions', BuyerTransactionController::class)->only('index');
Route::resource('buyers.products', BuyerProductController::class)->only('index');
Route::resource('buyers.sellers', BuyerSellerController::class)->only('index');
Route::resource('buyers.categories', BuyerCategoryController::class)->only('index');
