<?php

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

// Public API routes
Route::get('/status', function (Request $request) {
    return response()->json([
        'status' => 'operational',
        'timestamp' => now()->toISOString(),
        'version' => config('app.version', '1.0.0'),
    ]);
})->name('api.status');

// Authenticated API routes
// Note: For production, consider using Laravel Sanctum (auth:sanctum) for API authentication
// Install: composer require laravel/sanctum
// Then use: Route::middleware(['auth:sanctum'])->group(...)
// For now, using 'auth' (web guard) - works but not ideal for stateless APIs
Route::middleware(['auth'])->group(function () {
    Route::get('/user-data', function (Request $request) {
        return response()->json([
            'user' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'email_verified_at' => $request->user()->email_verified_at?->toISOString(),
            ],
            'timestamp' => now()->toISOString(),
        ]);
    })->name('api.user-data');
});

