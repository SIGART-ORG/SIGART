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

Route::get('/', function () {
    return view('index');
});

Route::get('/products/', 'ProductsController@index');
Route::get('/most-seen/', 'ProductsController@mostSeen');

Route::get('/blog/', 'BlogController@index');

Route::get('/about-us/', 'AboutUsController@index');