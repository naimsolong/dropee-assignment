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

use Modules\Admin\Http\Controllers;

Route::prefix('admin')->group(function() {
    Route::middleware(['admin.auth.already'])->group(function() {
        Route::get('/login', [Controllers\AuthController::class, 'login']);

        Route::post('/login', [Controllers\AuthController::class, 'loginAuth']);
    });
    
    Route::middleware(['admin.auth'])->group(function() {
        Route::get('/logout', [Controllers\AuthController::class, 'logout']);
        
        Route::get('/', [Controllers\AdminController::class, 'index']);

    });
});
