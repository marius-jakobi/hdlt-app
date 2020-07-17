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
    return view('welcome');
});

Route::get('/legal/imprint', function() {
    return view('static.imprint');
})->name('legal.imprint');
Route::get('/legal/data-protection', function() {
    return view('static.data-protection');
})->name('legal.data-protection');

// Login
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
// Registration
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');
// Logout
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
// Password confirmation
// Route::get('/password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
// Route::post('/password/confirm', 'Auth\ConfirmPasswordController@confirm');
// Forgot password
// Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
// Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// Update user password
Route::put('/password/update', 'UserController@updatePassword')->name('user.password.update');

// Only accessable when authenticated
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    // Profile
    Route::get('/profile', 'UserController@profile')->name('profile');

    // User list
    Route::get('/user/list', 'UserController@list')->name('user.list')->middleware('can:list,App\Models\User');
    // User update
    Route::put('/user/{id}', 'UserController@update')->name('user.update');
    // User delete
    Route::delete('/user/{id}', 'UserController@delete')->name('user.delete');
    // User details
    Route::get('/user/{id}', 'UserController@details')->name('user.details');
    // Attach/detach role to/from user
    Route::post('/user/{id}/role', 'RoleController@attachRoleToUser')->name('role.attach');
    Route::delete('/user/{id}/role', 'RoleController@detachRoleFromUser')->name('role.detach');

    // Role list
    Route::get('/roles', 'RoleController@list')->name('role.list')->middleware('can:list,App\Models\Role');
    // Create role
    Route::get('/role/create', 'RoleController@create')->name('role.create')->middleware('can:create,App\Models\Role');
    Route::post('/role/create', 'RoleController@store')->name('role.store')->middleware('can:create,App\Models\Role');
    // Attach/detach permission to/from role
    Route::post('/role/{name}/permission', 'PermissionController@attachPermissionToRole')->name('permission.attach');
    Route::delete('/role/{name}/permission', 'PermissionController@detachPermissionFromRole')->name('permission.detach');
    // Update role
    Route::put('/role/{name}', 'RoleController@update')->name('role.update');
    // Delete role
    Route::delete('/role/{id}', 'RoleController@delete')->name('role.delete')->middleware('can:delete,App\Models\Role');
    // Show role details
    Route::get('/role/{name}', 'RoleController@details')->name('role.details')->middleware('can:view,App\Models\Role');

    // Permission list
    Route::get('/permissions', 'PermissionController@list')->name('permission.list')->middleware('can:list,App\Models\Permission');
    // Permission create
    Route::get('/permissions/create', 'PermissionController@create')->name('permission.create')->middleware('can:create,App\Models\Permission');
    Route::post('/permissions/create', 'PermissionController@store')->name('permission.store')->middleware('can:create,App\Models\Permission');
    // Permission update
    Route::put('/permissions/{id}', 'PermissionController@update')->name('permission.update');
    // Permission details
    Route::get('/permissions/{name}', 'PermissionController@details')->name('permission.details')->middleware('can:view,App\Models\Permission');
    // Permission delete
    Route::delete('/permissions/{id}', 'PermissionController@delete')->name('permission.delete')->middleware('can:delete,App\Models\Permission');

    // Customer routes
    Route::get('/customers', 'CustomerController@list')->name('customer.list')->middleware('can:list,App\Models\Customer');
    Route::get('/customer/create', 'CustomerController@create')->name('customer.create');
    Route::post('/customer/create', 'CustomerController@store')->name('customer.store');
    Route::get('/customer/{customerId}/addresses/shipping/create', 'ShippingAddressController@create')->name('customer.addresses.shipping.create');
    Route::post('/customer/{customerId}/addresses/shipping/create', 'ShippingAddressController@store')->name('customer.addresses.shipping.store');
    Route::post('/customer/{customerId}/addresses/shipping/{addressId}/upload', 'UploadController@uploadShippingAddressFile')->name('upload.file.shipping-address');
    Route::get('/customer/{customerId}/addresses/shipping/{addressId}', 'ShippingAddressController@details')->name('customer.addresses.shipping.details');
    Route::put('/customer/{customerId}/addresses/shipping/{addressId}', 'ShippingAddressController@update')->name('customer.addresses.shipping.update');
    Route::get('/customer/{customerId}', 'CustomerController@details')->name('customer.details')->middleware('can:view,App\Models\Customer');
    Route::delete('/customer/{customerId}', 'CustomerController@delete')->name('customer.delete');

    // Component routes
    Route::get('/customer/{customerId}/addresses/shipping/{addressId}/{type}/add', 'ComponentController@create')->name('component.create');
    Route::post('/customer/{customerId}/addresses/shipping/{addressId}/{type}/add', 'ComponentController@store')->name('component.store');
    Route::post('/customer/{customerId}/addresses/shipping/{addressId}/{type}/{componentId}/upload', 'UploadController@uploadComponentFile')->name('upload.file.component');
    Route::get('/customer/{customerId}/addresses/shipping/{addressId}/{type}/{componentId}', 'ComponentController@details')->name('component.details');
    Route::put('/customer/{customerId}/addresses/shipping/{addressId}/{type}/{componentId}', 'ComponentController@update')->name('component.update');

    // Search routes
    Route::post('/search', 'SearchController@showResult')->name('search.result');

    // Process routes
    Route::post('sales/process/create/{custId}', 'SalesProcessController@store')->name('process.sales.store');
    Route::get('sales/process/create/{custId}', 'SalesProcessController@create')->name('process.sales.create');
    Route::get('sales/process/{processNumber}', 'SalesProcessController@details')->name('process.sales.details');
    Route::get('sales/service-report/{reportId}', 'ServiceReportController@details')->name('process.sales.service-report.details');
    
    // Order confirmations
    Route::get('sales/order-confirmation/create/{processNumber}', 'OrderConfirmationController@create')->name('process.sales.order-confirmation.create');
    Route::post('sales/order-confirmation/create/{processNumber}', 'OrderConfirmationController@store')->name('process.sales.order-confirmation.store');
    Route::get('sales/order-confirmation/{documentNumber}', 'OrderConfirmationController@details')->name('process.sales.order-confirmation.details');
});
