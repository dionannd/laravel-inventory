<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => 'auth:web'], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    // Category Route
    Route::resource('category', 'CategoryController');
    // Place Route
    Route::resource('place', 'PlaceController');
    // Product Route
    Route::resource('product', 'ProductController');
    // Customer Route
    Route::resource('customer', 'CustomerController');
    // Supplier Route
    Route::resource('supplier', 'SupplierController');
    // Sales Route
    Route::get('sales/show/{id}', 'SalesController@show')->name('sales.show');
    Route::post('sales/price', 'SalesController@getPrice')->name('sales.price');
    Route::resource('sales', 'SalesController');
    // Purchase Route
    Route::get('purchase/export_pdf/{id}', 'PurchaseController@export_pdf')->name('purchase.pdf');
    Route::get('purchase/approve/{id}', 'PurchaseController@approve')->name('purchase.approve');
    Route::get('purchase/show/{id}', 'PurchaseController@show')->name('purchase.show');
    Route::resource('purchase', 'PurchaseController');
    // Finance Route
    Route::resource('finance', 'FinanceController');
    // CashOut Route
    Route::resource('cashout', 'CashoutController');
    // Income Route
    Route::resource('income', 'IncomeController');
    // Loss Route
    Route::post('/loss/purchase', 'LossController@getData')->name('loss.getdata');
    Route::resource('loss', 'LossController');
});
