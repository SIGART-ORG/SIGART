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
use App\Access;

Route::group(['middleware' => ['guest']], function(){
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware' => ['auth']], function(){

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/main', 'PanelController@index')->name('main');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/ajax/days', 'AjaxController@arrayDays');/*Revisar donde se llama*/

    Route::group(['middleware' => ['permits:1']], function ( ) {

        Route::get('/module/dashboard', 'ModuleController@dashboard');
        Route::get('/module', 'ModuleController@index');
        Route::Post('/module/register', 'ModuleController@store');
        Route::PUT('/module/update', 'ModuleController@update');
        Route::Put('/module/deactivate', 'ModuleController@deactivate');
        Route::Put('/module/activate', 'ModuleController@activate');
        Route::Put('/module/delete', 'ModuleController@delete');
        Route::get('/module/select', 'ModuleController@selectModule');/*Revisar donde se llama*/

    });

    Route::group(['middleware' => ['permits:2']], function ( ) {

        Route::get('/user/dashboard', 'UserController@dashboard');
        Route::get('/user', 'UserController@index');
        Route::Post('/user/register', 'UserController@store');
        Route::PUT('/user/update', 'UserController@update');
        Route::Put('/user/deactivate', 'UserController@deactivate');
        Route::Put('/user/activate', 'UserController@activate');
        Route::Put('/user/delete', 'UserController@delete');

    });

    Route::group(['middleware' => ['permits:3']], function ( ) {

        Route::get('/role', 'RoleController@index');
        Route::get('/role/dashboard', 'RoleController@dashboard');
        Route::Post('/role/register', 'RoleController@store');
        Route::PUT('/role/update', 'RoleController@update');
        Route::Put('/role/deactivate', 'RoleController@deactivate');
        Route::Put('/role/activate', 'RoleController@activate');
        Route::Put('/role/delete', 'RoleController@delete');
        Route::get('/role/select', 'RoleController@selectRole');/*Revisar donde se llama*/
        Route::get('/role/show', 'RoleController@show');

    });


    Route::group(['middleware' => ['permits:4']], function ( ) {

        Route::get('/page', 'PageController@index');
        Route::get('/page/dashboard/{id?}', 'PageController@dashboard');
        Route::Post('/page/register', 'PageController@store');
        Route::PUT('/page/update', 'PageController@update');
        Route::Put('/page/deactivate', 'PageController@deactivate');
        Route::Put('/page/activate', 'PageController@activate');
        Route::Put('/page/delete', 'PageController@delete');

    });

    Route::group(['middleware' => ['permits:5']], function ( ) {

        Route::get('/access/dashboard/{id?}', 'AccessController@dashboard');
        Route::get('/access/{role_id?}', 'AccessController@index');
        Route::Post('/access', 'AccessController@accessSystem');

    });

    Route::group(['middleware' => ['permits:6']], function ( ) {

        Route::get('/icons/select', 'IconController@select');/*Revisar donde se llama*/
        Route::get('/icons', 'IconController@index');
        Route::get('/icons/dashboard', 'IconController@dashboard');
        Route::Post('/icons/register', 'IconController@store');
        Route::PUT('/icons/update', 'IconController@update');
        Route::Put('/icons/deactivate', 'IconController@deactivate');
        Route::Put('/icons/activate', 'IconController@activate');
        Route::Put('/icons/delete', 'IconController@delete');

    });

    Route::group(['middleware' => ['permits:7']], function ( ) {

        Route::get('/sites', 'SiteController@index');
        Route::get('/sites/dashboard', 'SiteController@dashboard');
        Route::post('/sites/register', 'SiteController@store');
        Route::put('/sites/update', 'SiteController@update');
        Route::put('/sites/deactivate', 'SiteController@deactivate');
        Route::put('/sites/activate', 'SiteController@activate');
        Route::Put('/sites/delete', 'SiteController@delete');

    });

    Route::group(['middleware' => ['permits:8']], function ( ) {

        Route::get('/categories', 'CategoryController@index');
        Route::get('/categories/dashboard', 'CategoryController@dashboard');
        Route::Post('/categories/register', 'CategoryController@store');
        Route::Put('/categories/update', 'CategoryController@update');
        Route::put('/categories/deactivate', 'CategoryController@deactivate');
        Route::put('/categories/activate', 'CategoryController@activate');
        Route::Put('/categories/delete', 'CategoryController@delete');

    });

    Route::group(['middleware' => ['permits:9']], function ( ) {

        Route::get('/holidays', 'HolidayController@index');
        Route::get('/holidays/dashboard', 'HolidayController@dashboard');
        Route::Post('/holidays/register', 'HolidayController@store');
        Route::put('/holidays/update', 'HolidayController@update');
        Route::put('/holidays/deactivate', 'HolidayController@deactivate');
        Route::put('/holidays/activate', 'HolidayController@activate');
        Route::Put('/holidays/delete', 'HolidayController@delete');

    });


    Route::group(['middleware' => ['permits:10']], function ( ) {

        Route::get('/calendar', 'GoogleCalendarController@index');
        Route::get('/calendar/dashboard', 'GoogleCalendarController@dashboard');
        Route::get('oauth', ['as' => 'oauthCallback', 'uses' => 'GoogleCalendarController@oauth']);
        Route::get('/calendario/list', 'GoogleCalendarController@list');

    });

    Route::group(['middleware' => ['permits:11']], function ( ) {

        Route::get('/unity/dashboard/{root?}', 'UnityController@dashboard');
        Route::get('/unity', 'UnityController@index');
        Route::post('/unity/register', 'UnityController@store');
        Route::put('/unity/update', 'UnityController@update');
        Route::put('/unity/deactivate', 'UnityController@deactivate');
        Route::put('/unity/activate', 'UnityController@activate');
        Route::Put('/unity/delete', 'UnityController@delete');

    });

    Route::group(['middleware' => ['permits:12']], function ( ) {
        Route::get('logs/dashboard', function(){
            $permiso = Access::sideBar();
            return view('modules.log', [
                "menu" => 2,
                'sidebar' => $permiso
            ]);
        });
        Route::get('logs/data', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    });

    Route::group(['middleware' => ['permits:13']], function ( ) {
        Route::get('loginUser/dashboard', 'UserController@loginUser');
        Route::get('supplant/{user?}', 'SupplantController@supplant');
    });

    Route::group(['middleware' => ['permits:14']], function ( ) {
        Route::get('products/dashboard', 'ProductController@dashboard');
        Route::get('products/', 'ProductController@index');
        Route::post('products/register', 'ProductController@store');
        Route::put('products/update', 'ProductController@update');
        Route::Put('products/delete', 'ProductController@destroy');
        Route::post('products/upload', 'ProductController@upload');

        Route::get('categories/select', 'CategoryController@select');
        Route::get('unity/select', 'UnityController@select');

        Route::get('productGalery/{id?}', 'ProductImageController@index');
        Route::put('productGalery/image-default/', 'ProductImageController@defaultImage');
    });

    Route::get('/reverse', 'SupplantController@reverse')->name('reverse');

    Route::get('/profile', 'UserController@profile');
    Route::get('/profile/data', 'UserController@dataSesion');
    Route::post('/profile/saveData', 'UserController@saveData');

});

/*Route::get('/test', function () {
    return view('test/contenido_test');
})->name('test');*/
