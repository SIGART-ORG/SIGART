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

Route::group(['middleware' => ['guest']], function(){
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::get('/main', function () {
    return view('inc/contenido');
})->name('main');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/role', 'RoleController@index');
Route::Post('/role/register', 'RoleController@store');
Route::PUT('/role/update', 'RoleController@update');
Route::Put('/role/deactivate', 'RoleController@deactivate');
Route::Put('/role/activate', 'RoleController@activate');
Route::Put('/role/delete', 'RoleController@delete');
Route::get('/role/select', 'RoleController@selectRole');
