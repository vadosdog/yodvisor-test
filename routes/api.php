<?php

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

// Auth routes
Route::group([
	'prefix' => 'auth'
], function ($router) {
	Route::post('login', 'AuthController@login');
	Route::group([
		'middleware' => 'auth:api'
	], function () {
		Route::post('logout', 'AuthController@logout');
		Route::post('refresh', 'AuthController@refresh');
		Route::post('me', 'AuthController@me');
	});

});

// Order routes

Route::group([
	'prefix' => 'orders'
], function () {
	Route::post('/', 'OrderController@add')->name('orders.create');
	Route::group([
		'middleware' => 'auth:api'
	], function () {
		Route::get('/', 'OrderController@get')->name('orders.list');
		Route::patch('/{order}', 'OrderController@update')
			->name('orders.update')
			->middleware('editable');
	});
});
