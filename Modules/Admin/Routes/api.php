<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Modules\Admin\Http\Controllers;

Route::prefix('admin')->middleware('auth:sanctum')->group(function() {
    Route::post('/get/all', [Controllers\ApiController::class, 'get_all']);
    
    Route::post('/save/setting', [Controllers\ApiController::class, 'save_setting']);
    
    Route::post('/save/sentence/{id?}', [Controllers\ApiController::class, 'save_sentence']);
    Route::post('/delete/sentence/{id}', [Controllers\ApiController::class, 'delete_sentence']);
});