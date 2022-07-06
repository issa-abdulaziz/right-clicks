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
    Route::get('/redirect-after-login', function () {
        // if (auth()->user()->is_admin)
        //     return redirect('/admin/task');
        // return redirect('/user/task');
        if (auth()->user()->is_admin)
            return 'admin';
        return 'user';
    });

    Route::get('/', function () {
        return view('welcome');
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'is_admin'], function () {
        Route::resource('department', \App\Http\Controllers\Admin\DepartmentController::class)->except(['show', 'create', 'edit']);
        Route::put('users/{user}/reset-password', \App\Http\Controllers\Admin\UserManagementController::class.'@resetPassword')->name('user.reset-password');
        Route::resource('user', \App\Http\Controllers\Admin\UserManagementController::class)->except(['show', 'create', 'edit']);
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

    });

});

Route::fallback(function () {
    return 'Page not found';
});
