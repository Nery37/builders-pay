<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BilletsController;
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

Route::get('health', function () {
    return response()->json(['message' => 'BUILDERS']);
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['prefix' => 'password'], function () {
        Route::post('forgot', [AuthController::class, 'forgot']);
        Route::post('resetPassword', [AuthController::class, 'resetPassword']);
    });
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('refresh-token', [AuthController::class, 'refreshToken'])
            ->middleware(['ability:' . \App\Enums\TokenAbilityEnum::ISSUE_ACCESS_TOKEN->value]);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});


Route::post('billet', [BilletsController::class, 'process']);


Route::any('/{any}', function () {
    return response()->json(['message' => 'Invalid router'], 404);
})->where('any', '.*');
