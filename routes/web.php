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

Route::redirect('/', '/task');

Route::middleware('auth')->group(function () {

    Route::get('task', \App\Http\Controllers\TaskController::class . '@index')->name('task.index');
    Route::put('task/{task}/update-status', \App\Http\Controllers\TaskController::class . '@updateStatus')->name('task.update-status');
    Route::group(['prefix' => 'profile'], function () {
        Route::view('password', 'profile.password')->name('password.edit');
        Route::view('edit', 'profile.edit')->name('profile.edit');
    });

    Route::group(['middleware' => 'is_admin'], function () {
        Route::get('dashboard', \App\Http\Controllers\DashboardController::class . '@index')->name('dashboard.index');
        Route::resource('department', \App\Http\Controllers\DepartmentController::class)->except(['show', 'create', 'edit']);
        Route::put('user/{user}/reset-password', \App\Http\Controllers\UserManagementController::class.'@resetPassword')->name('user.reset-password');
        Route::resource('user', \App\Http\Controllers\UserManagementController::class)->except(['show', 'create', 'edit']);
        Route::resource('task', \App\Http\Controllers\TaskController::class)->only(['store', 'update', 'destroy']);
    });

});

Route::fallback(function () {
    return 'Page not found';
});
