<?php

use App\Http\Controllers\Buyers\BuyerCategoryController;
use App\Http\Controllers\Buyers\BuyerProductController;
use App\Http\Controllers\Buyers\BuyersController;
use App\Http\Controllers\Buyers\BuyerSellerController;
use App\Http\Controllers\Buyers\BuyerTransactionController;
use App\Http\Controllers\Categories\CategoriesController;
use App\Http\Controllers\Categories\CategoryBuyerController;
use App\Http\Controllers\Categories\CategoryProductController;
use App\Http\Controllers\Categories\CategorySellerController;
use App\Http\Controllers\Categories\CategoryTransactionController;
use App\Http\Controllers\Products\ProductBuyerController;
use App\Http\Controllers\Products\ProductBuyerTransactionController;
use App\Http\Controllers\Products\ProductCategoryController;
use App\Http\Controllers\Products\ProductsController;
use App\Http\Controllers\Products\ProductTransactionController;
use App\Http\Controllers\Seller\SellerBuyerController;
use App\Http\Controllers\Seller\SellerCategoryController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellersController;
use App\Http\Controllers\Seller\SellerTransactionController;
use App\Http\Controllers\Transaction\TransactinCategoryController;
use App\Http\Controllers\Transaction\TransactionsController;
use App\Http\Controllers\Transaction\TransactionSellerController;
use App\Http\Controllers\User\UsersController;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;

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

/*
* Buyers Routes
*/
//Route::resource('buyers', BuyersController::class, ['only' => ['index', 'show']]);
Route::resource('buyers', BuyersController::class)->only('index', 'show');
Route::resource('buyers.transactions', BuyerTransactionController::class)->only('index');
Route::resource('buyers.products', BuyerProductController::class)->only('index');
Route::resource('buyers.sellers', BuyerSellerController::class)->only('index');
Route::resource('buyers.categories', BuyerCategoryController::class)->only('index');

/*
* Categories Routes
*/
Route::resource('categories', CategoriesController::class)->except('create,edit');
Route::resource('categories.products', CategoryProductController::class)->only('index');
Route::resource('categories.sellers', CategorySellerController::class)->only('index');
Route::resource('categories.transactions', CategoryTransactionController::class)->only('index');
Route::resource('categories.buyers', CategoryBuyerController::class)->only('index');

/*
* Products Routes
*/
Route::resource('products', ProductsController::class)->only('index', 'show');
Route::resource('products.buyers', ProductBuyerController::class)->only('index');
Route::resource('products.categories', ProductCategoryController::class)->only('index', 'update', 'destroy');
Route::resource('products.buyers.transactions', ProductBuyerTransactionController::class)->only('store');
Route::resource('products.transactions', ProductTransactionController::class)->only('index');

/*
* Sellers Routes
*/
Route::resource('sellers', SellersController::class)->only('index', 'show');
Route::resource('sellers.transactions', SellerTransactionController::class)->only('index');
Route::resource('sellers.categories', SellerCategoryController::class)->only('index');
Route::resource('sellers.buyers', SellerBuyerController::class)->only('index');
Route::resource('sellers.products', SellerProductController::class)->except('edit', 'create', 'show');

/*
* Transactions Routes
*/
Route::resource('transactions', TransactionsController::class)->only('index', 'show');
Route::resource('transactions.categories', TransactinCategoryController::class)->only('index');
Route::resource('transactions.sellers', TransactionSellerController::class)->only('index');

/*
* Users Routes
*/
Route::resource('users', UsersController::class)->except('create,edit');
Route::get('users/verify/{token}', [UsersController::class, 'verify'])->name('users.verify');
Route::get('users/{user}/resend-verification-email', [UsersController::class, 'resend'])->name('users.resend');

Passport::routes();
