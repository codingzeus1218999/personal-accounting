<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;

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

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Transaction routes
    Route::prefix('/transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index']); // List all transactions
        Route::post('/', [TransactionController::class, 'store']); // Add a new transaction
        Route::get('/{transaction}', [TransactionController::class, 'show']); // Show specific transaction
        Route::delete('/{transaction}', [TransactionController::class, 'destroy']); // Delete transaction
    });

    // Balance routes
    Route::get('/current-balance', [TransactionController::class, 'currentBalance']);
    Route::get('/balance-in-currency', function (Request $request) {
        $amount = auth()->user()->transactions()->sum('amount');
        $convertedAmount = convert_currency($amount, 'usd', $request->get('to', 'eur'));

        return response()->json([
            'original_amount' => $amount,
            'converted_amount' => $convertedAmount,
        ]);
    });
});
