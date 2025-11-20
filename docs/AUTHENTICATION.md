# Authentication Documentation

VILT Canvas uses Laravel Fortify for authentication, providing a headless authentication backend that works seamlessly with Inertia.js and Vue 3.

## Overview

Laravel Fortify is a frontend agnostic authentication backend for Laravel. It handles all authentication logic while you control the UI with Inertia.js and Vue components.

## Authentication Flow

### Registration Flow

```
User visits /register
    ↓
Fortify renders Auth/Register Inertia page
    ↓
User fills registration form
    ↓
POST /register
    ↓
Fortify validates and creates user
    ↓
If email verification enabled:
    - Send verification email
    - Redirect to /email/verify
Else:
    - Log user in
    - Redirect to home
```

### Login Flow

```
User visits /login
    ↓
Fortify renders Auth/Login Inertia page
    ↓
User enters credentials
    ↓
POST /login
    ↓
Fortify validates credentials
    ↓
If 2FA enabled:
    - Redirect to /two-factor-challenge
Else:
    - Log user in
    - Redirect to home
```

### Password Reset Flow

```
User visits /forgot-password
    ↓
User enters email
    ↓
POST /forgot-password
    ↓
Fortify sends reset link
    ↓
User clicks link in email
    ↓
Visits /reset-password/{token}
    ↓
User enters new password
    ↓
POST /reset-password
    ↓
Password updated, user logged in
    ↓
Redirect to home
```

### Two-Factor Authentication Flow

```
User enables 2FA in profile
    ↓
POST /user/two-factor-authentication
    ↓
Fortify generates secret and QR code
    ↓
User scans QR code with authenticator app
    ↓
User confirms with password + code
    ↓
2FA enabled
    ↓
On next login:
    - After password, redirect to /two-factor-challenge
    - User enters 2FA code
    - Login complete
```

## Fortify Configuration

### Features Enabled

All features are configured in `config/fortify.php`:

```php
'features' => [
    Features::registration(),              // User registration
    Features::resetPasswords(),           // Password reset
    Features::emailVerification(),        // Email verification
    Features::updateProfileInformation(), // Profile updates
    Features::updatePasswords(),          // Password changes
    Features::twoFactorAuthentication([   // 2FA
        'confirm' => true,
        'confirmPassword' => true,
    ]),
],
```

### Customization

#### Custom User Creation

Edit `app/Actions/Fortify/CreateNewUser.php`:

```php
public function create(array $input): User
{
    Validator::make($input, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ])->validate();

    return User::create([
        'name' => $input['name'],
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
        // Add custom fields here
    ]);
}
```

#### Custom Authentication Logic

Edit `app/Providers/FortifyServiceProvider.php`:

```php
Fortify::authenticateUsing(function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        // Add custom logic here
        if ($user->isActive()) {
            return $user;
        }
    }
});
```

## Available Routes

### Public Routes

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/login` | Login page |
| POST | `/login` | Process login |
| GET | `/register` | Registration page |
| POST | `/register` | Process registration |
| GET | `/forgot-password` | Password reset request page |
| POST | `/forgot-password` | Send password reset link |
| GET | `/reset-password/{token}` | Password reset form |
| POST | `/reset-password` | Process password reset |

### Authenticated Routes

| Method | Route | Description |
|--------|-------|-------------|
| POST | `/logout` | Logout user |
| GET | `/email/verify` | Email verification notice |
| POST | `/email/verification-notification` | Resend verification email |
| GET | `/email/verify/{id}/{hash}` | Verify email |
| POST | `/user/confirm-password` | Confirm password |
| PUT | `/user/profile-information` | Update profile |
| PUT | `/user/password` | Update password |
| POST | `/user/two-factor-authentication` | Enable 2FA |
| DELETE | `/user/two-factor-authentication` | Disable 2FA |
| GET | `/user/two-factor-qr-code` | Get 2FA QR code |
| GET | `/user/two-factor-recovery-codes` | Get recovery codes |
| POST | `/user/two-factor-recovery-codes` | Regenerate recovery codes |

### Two-Factor Routes

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/two-factor-challenge` | 2FA challenge page |
| POST | `/two-factor-challenge` | Verify 2FA code |

## Middleware

### Authentication Middleware

Routes are protected using Laravel's built-in middleware:

```php
// In routes/web.php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', ...);
});
```

**Middleware Chain:**
1. `auth` - Ensures user is authenticated
2. `verified` - Ensures email is verified (if enabled)

### Custom Middleware

Create custom middleware for additional checks:

```php
// app/Http/Middleware/EnsureUserIsActive.php
public function handle(Request $request, Closure $next)
{
    if (!$request->user()->isActive()) {
        abort(403, 'Your account is inactive.');
    }

    return $next($request);
}
```

Register in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->web(append: [
        \App\Http\Middleware\EnsureUserIsActive::class,
    ]);
})
```

## Two-Factor Authentication

### Setup

1. **Enable in Config**

Already enabled in `config/fortify.php`:

```php
Features::twoFactorAuthentication([
    'confirm' => true,           // Require confirmation to enable
    'confirmPassword' => true,   // Require password confirmation
]),
```

2. **Database Migration**

The migration `add_two_factor_columns_to_users_table` adds:
- `two_factor_secret`
- `two_factor_recovery_codes`
- `two_factor_confirmed_at`

3. **User Interface**

Users can enable 2FA in `/profile` under "Two Factor Authentication" section.

### How It Works

1. User clicks "Enable" in profile
2. Enters password to confirm
3. Backend generates secret and QR code
4. User scans QR code with authenticator app
5. User enters code to confirm
6. 2FA is enabled

### Recovery Codes

When 2FA is enabled, recovery codes are generated. Users should:
- Save codes securely
- Use codes if authenticator device is lost
- Regenerate codes if needed

### Disabling 2FA

Users can disable 2FA from profile page. Password confirmation is required.

## Email Verification

### Setup

Email verification is enabled by default. Users must verify their email before accessing protected routes.

### Customization

**Change Verification Email:**

Edit `app/Actions/Fortify/SendEmailVerificationNotification.php` or use Laravel's notification system.

**Skip Verification for Testing:**

```php
// In User model
public function hasVerifiedEmail(): bool
{
    if (app()->environment('local')) {
        return true; // Skip in local
    }
    return ! is_null($this->email_verified_at);
}
```

## Rate Limiting

Fortify includes rate limiting to prevent abuse:

```php
// config/fortify.php
'limiters' => [
    'login' => 'login',        // 5 attempts per minute
    'two-factor' => 'two-factor', // 5 attempts per minute
],
```

### Custom Rate Limits

Edit `app/Providers/FortifyServiceProvider.php`:

```php
RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(10)->by($request->ip());
});
```

## Password Requirements

### Default Rules

Passwords must:
- Be at least 8 characters
- Be confirmed (matching confirmation field)

### Custom Rules

Edit `app/Actions/Fortify/CreateNewUser.php`:

```php
Validator::make($input, [
    'password' => [
        'required',
        'string',
        'min:12',              // Minimum 12 characters
        'regex:/[A-Z]/',       // At least one uppercase
        'regex:/[a-z]/',       // At least one lowercase
        'regex:/[0-9]/',       // At least one number
        'regex:/[@$!%*#?&]/', // At least one special char
        'confirmed',
    ],
])->validate();
```

## Session Management

### Remember Me

The login form includes a "Remember me" checkbox that extends the session lifetime.

### Session Configuration

Configure in `config/session.php`:

```php
'lifetime' => 120, // Minutes
'expire_on_close' => false,
```

## Security Best Practices

1. **Use HTTPS in Production**
   - Ensures credentials are encrypted
   - Required for secure cookies

2. **Enable Rate Limiting**
   - Prevents brute force attacks
   - Already configured by default

3. **Strong Passwords**
   - Enforce minimum requirements
   - Consider password strength meters

4. **Two-Factor Authentication**
   - Encourage users to enable 2FA
   - Provide clear setup instructions

5. **Email Verification**
   - Verify email addresses
   - Prevent fake accounts

6. **Session Security**
   - Use secure cookies
   - Set appropriate session lifetime
   - Regenerate session on login

## Troubleshooting

### Login Not Working

1. Check credentials are correct
2. Verify user exists in database
3. Check rate limiting hasn't blocked IP
4. Verify CSRF token is included

### 2FA Not Working

1. Check time sync on device
2. Verify QR code was scanned correctly
3. Check recovery codes if device lost
4. Verify 2FA is actually enabled

### Email Verification Not Sending

1. Check mail configuration in `.env`
2. Verify mail driver is working
3. Check spam folder
4. Test with mail log driver

### Session Expiring Too Quickly

1. Check `config/session.php` lifetime
2. Verify `remember` checkbox is working
3. Check cookie settings

## Additional Resources

- [Laravel Fortify Documentation](https://laravel.com/docs/fortify)
- [Laravel Authentication Documentation](https://laravel.com/docs/authentication)
- [Two-Factor Authentication Best Practices](https://cheatsheetseries.owasp.org/cheatsheets/Multifactor_Authentication_Cheat_Sheet.html)

