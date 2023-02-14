<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DebtorController;

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


Route::prefix('auth')->group(function (){
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth:sanctum')->apiResource('installments', InstallmentController::class);
Route::middleware('auth:sanctum')->apiResource('users', UserController::class);
Route::middleware('auth:sanctum')->apiResource('debtors', DebtorController::class);

Route::middleware('auth:sanctum')->prefix('debtors')->group(function (){
    Route::get('/user/{id}', [DebtorController::class, 'usersDebtors']);
    Route::get('/payers/user/{id}', [DebtorController::class, 'payers']);
    Route::get('/defaulters/user/{id}',[DebtorController::class, 'defaulters']);
});
