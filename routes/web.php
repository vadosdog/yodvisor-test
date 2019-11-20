<?php

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

// Create order routes
Route::get('/', function () {
    return view('newOrderPage');
})->name('orders.newOrder');

Route::group([
	'prefix' => 'orders'
], function () {
	Route::post('/orders/', 'OrderController@add')->name('orders.create');
	Route::group([
		'middleware' => 'auth'
	], function () {
		Route::get('/', 'OrderController@get')->name('orders.list');
		Route::post('/{order}', 'OrderController@update')->name('orders.update');
	});
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
