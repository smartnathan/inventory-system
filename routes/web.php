<?php

use App\Sale;
use App\User;
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

// Route::get('/create', function(){
// 	$user = User::create(['name'=>'NAthaniel David', 'password'=>bcrypt('xbba063nath'), 'email'=> 'david.nathaniel13@gmail.com', 'gender' => 'male']);
// 	$user->assignRole('maintenance-admin');
// });

Route::get('/', 'Auth\\LoginController@showLoginForm');

Auth::routes(['register' => false]);

//Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function(){

Route::get('admin/stocks/products/{code}', 'Admin\SalesController@getProductAndStock');
Route::get('admin/reports/sales', 'ReportsController@sales');
Route::get('admin/sales/invoice/{id}', 'Admin\SalesController@invoice');
Route::get('admin/sales/invoice-print/{id}', 'Admin\SalesController@invoice_print');
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
// Route::get('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
// Route::post('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);

Route::resource('admin/stores', 'Admin\\StoresController');
Route::resource('admin/stocks', 'Admin\\StockController');
Route::resource('admin/categories', 'Admin\\CategoriesController');
Route::resource('admin/suppliers', 'Admin\\SuppliersController');
Route::resource('admin/manufacturers', 'Admin\\ManufacturersController');
Route::resource('admin/brands', 'Admin\\BrandsController');
Route::resource('admin/customers', 'Admin\\CustomersController');
Route::resource('admin/unit-of-measurements', 'Admin\\UnitOfMeasurementsController');
Route::resource('admin/products', 'Admin\\ProductsController');
Route::get('admin/product/generate', 'Admin\\ProductsController@generate');
Route::get('admin/product/generate-thermal', 'Admin\\ProductsController@generate_thermal');
Route::resource('admin/purchase-order-headers', 'Admin\\PurchaseOrderHeadersController');

Route::resource('admin/sales', 'Admin\\SalesController');

Route::resource('admin/services', 'Admin\\ServicesController');
Route::resource('admin/service-reports', 'Admin\\ServiceReportsController');
Route::resource('admin/service-reports', 'Admin\\ServiceReportsController');

});


