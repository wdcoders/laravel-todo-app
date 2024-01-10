<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // $todos
    Route::get('/todo', [TodoController::class, 'index']);
    Route::get('/todo/{id}', [TodoController::class, 'show']);
    Route::post('/todo', [TodoController::class, 'store']);
    Route::put('/todo/{id}', [TodoController::class, 'update']);
    Route::post('/todo/{id}/update-status', [TodoController::class, 'updateStatus']);
    Route::delete('/todo/{id}', [TodoController::class, 'destroy']);
});
