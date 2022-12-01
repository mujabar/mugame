<?php

use App\Http\Controllers\Api\Admin\GameController;
use App\Http\Controllers\Api\Admin\ItemController;
use App\Http\Controllers\Api\Admin\TransactionController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\User\ItemController as UserItemController;
use App\Http\Controllers\Api\User\MyOrderController;
use App\Http\Controllers\Api\User\OrderItemController;
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

Route::post('login', [AuthController::class, 'login']);
Route::post('register',   [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::prefix('admin')->group(function () {
        Route::resource('item', ItemController::class);
        Route::resource('game', GameController::class);
        Route::resource('transaction', TransactionController::class);
    });

    Route::get('my-order', [MyOrderController::class, 'index']);
    Route::post('process-payment', [MyOrderController::class, 'processPaymentOrder']);
    Route::post('order-product/{id}', [OrderItemController::class, 'store']);

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('items', [UserItemController::class, 'index']);
Route::get('item/{id}', [UserItemController::class, 'show']);
