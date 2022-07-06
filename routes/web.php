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

Route::middleware('auth')->group(function () {
    Route::get('redirect-after-login', function () {
        if (auth()->user()->is_admin)
            return redirect()->route('task.index');
        // return redirect('/user/task');
        return 'user';
    });

    Route::redirect('/', 'redirect-after-login');

    Route::group(['prefix' => 'admin', 'middleware' => 'is_admin'], function () {
        Route::resource('department', \App\Http\Controllers\DepartmentController::class)->except(['show', 'create', 'edit']);
        Route::put('user/{user}/reset-password', \App\Http\Controllers\UserManagementController::class.'@resetPassword')->name('user.reset-password');
        Route::resource('user', \App\Http\Controllers\UserManagementController::class)->except(['show', 'create', 'edit']);
        Route::resource('task', \App\Http\Controllers\TaskController::class)->except(['show', 'create', 'edit']);
    });

    Route::group(['prefix' => 'user'], function () {

    });

});

Route::fallback(function () {
    return 'Page not found';
});
