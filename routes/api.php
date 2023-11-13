<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\UserController;
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

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', function () {
    return view('home');
});

// Auth
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword']);

/*
|--------------------------------------------------------------------------
| Administrator
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Users
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| Private
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->group(function () {
    // Users
    Route::get('/user/list/restrict', [UserController::class, 'restrictList']);

    // Auth
    Route::get('/auth/validate-token', [AuthController::class, 'validateToken']);
    Route::post('/auth/change-password', [AuthController::class, 'changePassword']);
    Route::post('/auth/change-profile', [AuthController::class, 'changeProfile']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    // Inspections
    Route::prefix('inspection')->group(function () {
        Route::get('/', [InspectionController::class, 'index']);
        Route::get('/{user_id}/{start_date}/{end_date}', [InspectionController::class, 'filter']);
        Route::get('/{id}', [InspectionController::class, 'show']);
        Route::post('/', [InspectionController::class, 'store']);
        Route::delete('/{id}', [InspectionController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| Not Found
|--------------------------------------------------------------------------
*/

Route::any('{any}', function () {
    return response()->json([
        'message'   => 'Recurso não encontrado.',
    ], HTTP_CODE_NOT_FOUND);
})->where('any', '.*');
