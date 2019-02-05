<?php

use App\Sale;
use Carbon\Carbon;

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

Route::get('/', 'Auth\\LoginController@showLoginForm');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function(){
Route::get('admin/sales/invoice/{id}', 'Admin\SalesController@invoice');
Route::get('admin/products/low-product', 'Admin\ProductsController@low_product');
Route::get('admin', 'Admin\AdminController@index');
Route::resource('admin/roles', 'Admin\RolesController');
Route::resource('admin/permissions', 'Admin\PermissionsController');
Route::resource('admin/users', 'Admin\UsersController');
Route::resource('admin/pages', 'Admin\PagesController');
Route::resource('admin/activitylogs', 'Admin\ActivityLogsController')->only([
    'index', 'show', 'destroy'
]);
Route::resource('admin/settings', 'Admin\SettingsController');
Route::get('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
Route::post('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);

Route::resource('admin/stores', 'Admin\\StoresController');
Route::resource('admin/categories', 'Admin\\CategoriesController');
Route::resource('admin/suppliers', 'Admin\\SuppliersController');
Route::resource('admin/manufacturers', 'Admin\\ManufacturersController');
Route::resource('admin/brands', 'Admin\\BrandsController');
Route::resource('admin/customers', 'Admin\\CustomersController');
Route::resource('admin/unit-of-measurements', 'Admin\\UnitOfMeasurementsController');
Route::resource('admin/products', 'Admin\\ProductsController');
Route::resource('admin/purchase-order-headers', 'Admin\\PurchaseOrderHeadersController');

Route::resource('admin/sales', 'Admin\\SalesController');
});

Route::resource('admin/services', 'Admin\\ServicesController');
Route::resource('admin/service-reports', 'Admin\\ServiceReportsController');
Route::resource('admin/service-reports', 'Admin\\ServiceReportsController');
