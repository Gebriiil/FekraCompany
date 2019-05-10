<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login','Auth\UserLoginController@login');
Route::post('register','Auth\UserLoginController@register');
Route::get('logout','ProductController@logout');
Route::post('update/{id}','ProductController@update');
Route::delete('delete/{id}','ProductController@delete');
Route::get('show/{id}','ProductController@show');
Route::get('addto-favorit/{id}','ProductController@addToWhishlist');
Route::get('my-favorits','ProductController@MyWhishlist');
Route::get('my-products','ProductController@myproducts');
Route::post('add-product','ProductController@store');
