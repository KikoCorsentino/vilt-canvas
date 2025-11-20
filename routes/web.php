<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Welcome page (public)
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

// Colors page (public)
Route::get('/colors', function () {
    return Inertia::render('Colors');
})->name('colors');

// Authentication view routes (GET routes for Inertia views)
// These are needed because Fortify with views => false doesn't register GET routes
Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->middleware('guest')->name('login');

Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->middleware('guest')->name('register');

Route::get('/forgot-password', function () {
    return Inertia::render('Auth/ForgotPassword');
})->middleware('guest')->name('password.request');

Route::get('/reset-password/{token}', function (\Illuminate\Http\Request $request) {
    return Inertia::render('Auth/ResetPassword', [
        'token' => $request->route('token'),
        'email' => $request->email,
    ]);
})->middleware('guest')->name('password.reset');

Route::get('/email/verify', function () {
    return Inertia::render('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

// Authentication routes (handled by Fortify, but views are custom)
// Fortify automatically registers these POST routes:
// - GET /login (login view)
// - POST /login (login)
// - POST /logout (logout)
// - GET /register (register view)
// - POST /register (register)
// - GET /forgot-password (forgot password view)
// - POST /forgot-password (send reset link)
// - GET /reset-password/{token} (reset password view)
// - POST /reset-password (reset password)
// - GET /email/verify (email verification view)
// - POST /email/verification-notification (resend verification)
// - GET /email/verify/{id}/{hash} (verify email)
// - POST /user/confirm-password (confirm password)
// - PUT /user/password (update password)
// - PUT /user/profile-information (update profile)
// - POST /user/two-factor-authentication (enable 2FA)
// - DELETE /user/two-factor-authentication (disable 2FA)
// - GET /user/two-factor-qr-code (get QR code)
// - GET /user/two-factor-recovery-codes (get recovery codes)
// - POST /user/two-factor-recovery-codes (regenerate recovery codes)

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Demo page
    Route::get('/demo', function () {
        return Inertia::render('Demo');
    })->name('demo');

    // Profile routes
    Route::get('/profile', function (\Illuminate\Http\Request $request) {
        $user = $request->user();

        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail,
            'status' => session('status'),
            'enabled' => $user->two_factor_confirmed_at !== null,
            'qrCode' => null, // QR code is fetched via separate endpoint when enabling 2FA
            'recoveryCodes' => [], // Recovery codes are fetched via separate endpoint
        ]);
    })->name('profile.edit');

    // Delete user account
    Route::delete('/user', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'password' => ['required', 'current_password:web'],
        ], [
            'password.current_password' => __('The provided password does not match your current password.'),
        ]);

        $user = $request->user();

        auth()->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    })->name('profile.destroy');
});
