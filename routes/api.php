<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'client'], function () {
    Route::get('menus', [App\Http\Controllers\MenuController::class, 'index']);
    Route::get('pages', [App\Http\Controllers\PageController::class, 'index']);
    Route::get('slider', [App\Http\Controllers\ContentController::class, 'index']);
});
