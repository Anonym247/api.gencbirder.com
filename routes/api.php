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

    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);
        Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);

        Route::group(['middleware' => 'auth:api'], function () {
            Route::put('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
            Route::get('logout', [App\Http\Controllers\AuthController::class, 'logout']);
            Route::put('changePassword', [App\Http\Controllers\AuthController::class, 'changePassword']);
        });
    });

    Route::group(['prefix' => 'shared'], function () {
        Route::get('provinces', [App\Http\Controllers\ReferenceController::class, 'provinces']);
        Route::get('provinces/{id}/districts', [App\Http\Controllers\ReferenceController::class, 'districts']);
        Route::get('districts/{id}/quarters', [App\Http\Controllers\ReferenceController::class, 'quarters']);
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('profile', [App\Http\Controllers\UserController::class, 'getProfile']);
        Route::put('profile', [App\Http\Controllers\UserController::class, 'update']);

        Route::group(['prefix' => 'addresses'], function () {
            Route::get('types', [App\Http\Controllers\UserAddressController::class, 'getUserAddressTypes']);
            Route::get('/', [App\Http\Controllers\UserAddressController::class, 'index']);
            Route::post('/', [App\Http\Controllers\UserAddressController::class, 'store']);
            Route::put('/{id}', [App\Http\Controllers\UserAddressController::class, 'update']);
            Route::delete('/{id}', [App\Http\Controllers\UserAddressController::class, 'destroy']);
        });
    });

    Route::get('menus', [App\Http\Controllers\MenuController::class, 'index']);
    Route::get('pages', [App\Http\Controllers\PageController::class, 'index']);
    Route::get('slider', [App\Http\Controllers\ContentController::class, 'slider']);
    Route::get('stats', [App\Http\Controllers\ContentController::class, 'stats']);
    Route::get('activities', [App\Http\Controllers\ContentController::class, 'activities']);
    Route::get('news', [App\Http\Controllers\ContentController::class, 'news']);
});
