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

Route::redirect('/', 'user/task');

Route::middleware('auth')->group(function () {

    Route::group(['prefix' => 'user'], function () {
        Route::get('task', \App\Http\Controllers\TaskController::class . '@index')->name('task.index');
        Route::put('task/{task}', \App\Http\Controllers\TaskController::class . '@updateStatus')->name('task.update-status');
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'is_admin'], function () {
        Route::resource('department', \App\Http\Controllers\DepartmentController::class)->except(['show', 'create', 'edit']);
        Route::put('user/{user}/reset-password', \App\Http\Controllers\UserManagementController::class.'@resetPassword')->name('user.reset-password');
        Route::resource('user', \App\Http\Controllers\UserManagementController::class)->except(['show', 'create', 'edit']);
        Route::resource('task', \App\Http\Controllers\TaskController::class)->only(['store', 'update', 'destroy']);
    });

});

Route::fallback(function () {
    return 'Page not found';
});
