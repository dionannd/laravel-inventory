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
    Route::resource('/place', 'PlaceController');
    // Product Route
    Route::get('/product/delete/{id}','ProductController@destroy')->name('product.destroy');
    Route::resource('/product', 'ProductController');
    // Customer Route
    Route::get('/customer/delete/{id}', 'CustomerController@destroy')->name('customer.destroy');
    Route::resource('/customer', 'CustomerController');
    // Supplier Route
    Route::get('/supplier/delete/{id}', 'SupplierController@destroy')->name('supplier.destroy');
    Route::resource('/supplier', 'SupplierController');
    // Sales Route
    Route::get('/sales/delete/{id}', 'SalesController@destroy')->name('sales.destroy');
    Route::resource('/sales', 'SalesController');
    // Price Sales from Product
    Route::post('/sales/price', 'SalesController@getPrice')->name('sales.price');
    // Inovoice Sales
    Route::get('sales/show/{id}', 'SalesController@show')->name('sales.show');
    // Purchase Route
    Route::get('/purchase/delete/{id}', 'PurchaseController@destroy')->name('purchase.destroy');
    Route::resource('/purchase', 'PurchaseController');
    // Approve Purchase
    Route::get('/purchase/approve/{id}', 'PurchaseController@approve')->name('purchase.approve');
    // Excel Purchase
    Route::get('purchase/export_pdf/{id}', 'PurchaseController@export_pdf')->name('purchase.pdf');
    // Invoice Purchase
    Route::get('purchase/show/{id}', 'PurchaseController@show')->name('purchase.show');
    // Finance Route
    Route::get('/finance/delete/{id}', 'FinanceController@destroy')->name('finance.destroy');
    Route::resource('/finance', 'FinanceController');
    // CashOut Route
    Route::resource('/cashout', 'CashoutController');
    Route::get('/cashout/delete/{id}', 'CashoutController@destroy')->name('cashout.destroy');
    // Loss Route
    Route::get('/loss/delete/{id}', 'LossController@destroy')->name('loss.destroy');
    Route::resource('loss', 'LossController');
    // Get data from Sales
    Route::post('/loss/purchase', 'LossController@getData')->name('loss.getdata');
});
