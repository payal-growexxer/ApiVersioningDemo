<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController as UserControllerV1;
use App\Http\Controllers\Api\V2\UserController as UserControllerV2;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('/users', [UserControllerV1::class, 'index']);
});

Route::prefix('v2')->group(function () {
    Route::get('/users', [UserControllerV2::class, 'index']);
});

Route::middleware('api.version')->group(function () {
    Route::get('/users', function (Request $request) {
        $version = $request->get('api_version');

        return $version === 'v2' ? 
            (new \App\Http\Controllers\Api\V2\UserController)->index() :
            (new \App\Http\Controllers\Api\V1\UserController)->index();
    });
});
