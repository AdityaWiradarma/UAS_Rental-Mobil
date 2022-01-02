<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Mobils;
use App\Http\Livewire\Types;
use App\Http\Livewire\Product;
use App\Http\Livewire\Cart;
use App\Http\Livewire\Transactions;
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


Route::group(['middleware' => ['auth:sanctum','verified','accessrole']], function(){

    Route::middleware(['auth:sanctum', 'verified','accessrole'])->get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/mobils',mobils::class)->name('mobils');;
    Route::get('/product',Product::class)->name('product');;
    Route::get('/types',Types::class)->name('types');;
    Route::get('/cart',Cart::class)->name('cart');;
    Route::get('/transactions', Transactions::class)->name('transactions');

});

