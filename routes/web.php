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

// Login
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
// Registration
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');
// Logout
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
// Password confirmation
Route::get('/password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('/password/confirm', 'Auth\ConfirmPasswordController@confirm');
// Forgot password
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

// Only accessable when authenticated
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    // Profile
    Route::get('/profile', 'UserController@profile')->name('profile');

    // User list
    Route::get('/user/list', 'UserController@list')->name('user.list')->middleware('can:admin,App\User');
    // User update
    Route::put('/user/{id}', 'UserController@update')->name('user.update')->middleware('can:admin,App\User');
    // User delete
    Route::delete('/user/{id}', 'UserController@delete')->name('user.delete')->middleware('can:admin,App\User');
    // User details
    Route::get('/user/{id}', 'UserController@details')->name('user.details')->middleware('can:admin,App\User');
    // Attach/detach role to/from user
    Route::post('/user/{id}/role', 'RoleController@attachRoleToUser')->name('role.attach')->middleware('can:admin,App\User');
    Route::delete('/user/{id}/role', 'RoleController@detachRoleFromUser')->name('role.detach')->middleware('can:admin,App\User');

    // Role list
    Route::get('/roles', 'RoleController@list')->name('role.list')->middleware('can:admin,App\Role');
    // Create role
    Route::get('/role/create', 'RoleController@create')->name('role.create')->middleware('can:admin,App\Role');
    Route::post('/role/create', 'RoleController@store')->name('role.store')->middleware('can:admin,App\Role');
    // Attach/detach permission to/from role
    Route::post('/role/{name}/permission', 'PermissionController@attachPermissionToRole')->name('permission.attach')->middleware('can:admin,App\Role');
    Route::delete('/role/{name}/permission', 'PermissionController@detachPermissionFromRole')->name('permission.detach')->middleware('can:admin,App\Role');
    // Update role
    Route::put('/role/{name}', 'RoleController@update')->name('role.update')->middleware('can:admin,App\Role');
    // Delete role
    Route::delete('/role/{id}', 'RoleController@delete')->name('role.delete')->middleware('can:admin,App\Role');
    // Show role details
    Route::get('/role/{name}', 'RoleController@details')->name('role.details')->middleware('can:admin,App\Role');
});
