# API Documentation

VILT Canvas includes example API routes to demonstrate API integration patterns. For production applications, consider using Laravel Sanctum for stateless API authentication.

## Overview

The API routes are defined in `routes/api.php` and are prefixed with `/api` by default. These routes demonstrate basic API patterns but should be extended based on your application's needs.

## Available Routes

### Public Routes

#### GET /api/status

Get API status and version information.

**Response:**
```json
{
  "status": "operational",
  "timestamp": "2024-01-01T12:00:00.000000Z",
  "version": "1.0.0"
}
```

**Example:**
```bash
curl http://localhost:8000/api/status
```

### Authenticated Routes

#### GET /api/user-data

Get authenticated user data.

**Authentication:** Required (web guard)

**Response:**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "email_verified_at": "2024-01-01T12:00:00.000000Z"
  },
  "timestamp": "2024-01-01T12:00:00.000000Z"
}
```

**Example:**
```bash
# With session cookie (web guard)
curl -X GET http://localhost:8000/api/user-data \
  -H "Cookie: laravel_session=..."
```

## Authentication

### Current Implementation

The example API routes use Laravel's `auth` middleware, which uses session-based authentication (web guard). This works for:
- Same-origin requests
- Applications where API and web share the same domain
- Development and testing

### Production: Laravel Sanctum

For production APIs, especially for:
- Mobile applications
- SPA frontends on different domains
- Stateless API authentication

Install and configure Laravel Sanctum:

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

**Update API Routes:**

```php
// routes/api.php
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user-data', function (Request $request) {
        return response()->json([
            'user' => $request->user(),
        ]);
    });
});
```

**Frontend Authentication:**

```javascript
// Login and get token
const response = await axios.post('/login', {
    email: 'user@example.com',
    password: 'password',
});

const token = response.data.token;

// Use token in subsequent requests
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
```

## CORS Configuration

### Default Configuration

Laravel includes CORS middleware. Configure in `config/cors.php`:

```php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    
    'allowed_methods' => ['*'],
    
    'allowed_origins' => [
        'http://localhost:3000',
        'https://yourdomain.com',
    ],
    
    'allowed_origins_patterns' => [],
    
    'allowed_headers' => ['*'],
    
    'exposed_headers' => [],
    
    'max_age' => 0,
    
    'supports_credentials' => true,
];
```

### Environment Configuration

Set in `.env`:

```env
SANCTUM_STATEFUL_DOMAINS=localhost:3000,localhost:5173
SESSION_DOMAIN=localhost
```

## Example API Usage

### JavaScript/Fetch

```javascript
// Get status
const response = await fetch('/api/status');
const data = await response.json();
console.log(data);

// Get user data (with session)
const userResponse = await fetch('/api/user-data', {
    credentials: 'include', // Include cookies
});
const userData = await userResponse.json();
console.log(userData);
```

### Axios

```javascript
import axios from 'axios';

// Configure axios
axios.defaults.withCredentials = true;

// Get status
const status = await axios.get('/api/status');
console.log(status.data);

// Get user data
const userData = await axios.get('/api/user-data');
console.log(userData.data);
```

### Vue 3 with Inertia

While Inertia handles most data fetching, you can still use the API:

```vue
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const status = ref(null);

onMounted(async () => {
    try {
        const response = await axios.get('/api/status');
        status.value = response.data;
    } catch (error) {
        console.error('Failed to fetch status:', error);
    }
});
</script>

<template>
    <div v-if="status">
        <p>Status: {{ status.status }}</p>
        <p>Version: {{ status.version }}</p>
    </div>
</template>
```

## Extending the API

### Adding New Routes

```php
// routes/api.php
Route::middleware(['auth'])->group(function () {
    // Existing routes...
    
    // New route
    Route::get('/posts', function () {
        return response()->json([
            'posts' => Post::all(),
        ]);
    });
    
    Route::post('/posts', function (Request $request) {
        $post = Post::create($request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]));
        
        return response()->json($post, 201);
    });
});
```

### Using API Resources

For consistent API responses, use Laravel API Resources:

```bash
php artisan make:resource UserResource
```

```php
// app/Http/Resources/UserResource.php
class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
        ];
    }
}
```

```php
// routes/api.php
Route::get('/users', function () {
    return UserResource::collection(User::all());
});
```

### Rate Limiting

Add rate limiting to API routes:

```php
// routes/api.php
Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('/status', ...);
});
```

Or use named limiters:

```php
// bootstrap/app.php
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});
```

```php
// routes/api.php
Route::middleware(['throttle:api'])->group(function () {
    // Routes
});
```

## Error Handling

### Standard Error Responses

Laravel automatically returns JSON errors for API requests:

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password field is required."]
  }
}
```

### Custom Error Responses

```php
Route::get('/api/data', function (Request $request) {
    try {
        // Your logic
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Something went wrong',
            'message' => $e->getMessage(),
        ], 500);
    }
});
```

## API Versioning

For API versioning, organize routes:

```php
// routes/api.php
Route::prefix('v1')->group(function () {
    Route::get('/users', ...);
});

Route::prefix('v2')->group(function () {
    Route::get('/users', ...);
});
```

Or use subdomain versioning:

```php
// routes/api.php
Route::domain('api.example.com')->group(function () {
    Route::prefix('v1')->group(function () {
        // v1 routes
    });
});
```

## Testing API Routes

### Using Pest

```php
// tests/Feature/ApiTest.php
test('can get api status', function () {
    $response = $this->getJson('/api/status');
    
    $response->assertStatus(200)
        ->assertJson([
            'status' => 'operational',
        ]);
});

test('can get user data when authenticated', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->getJson('/api/user-data');
    
    $response->assertStatus(200)
        ->assertJsonStructure([
            'user' => ['id', 'name', 'email'],
        ]);
});
```

## Security Best Practices

1. **Use HTTPS in Production**
   - Encrypts API traffic
   - Required for secure cookies

2. **Implement Rate Limiting**
   - Prevents abuse
   - Protects against DDoS

3. **Validate All Input**
   - Use Form Requests
   - Sanitize user input

4. **Use API Resources**
   - Control response structure
   - Hide sensitive data

5. **Implement CORS Properly**
   - Only allow trusted origins
   - Use credentials carefully

6. **Use Sanctum for Stateless APIs**
   - Better for mobile apps
   - Token-based authentication

## Additional Resources

- [Laravel API Documentation](https://laravel.com/docs/routing#api-routes)
- [Laravel Sanctum Documentation](https://laravel.com/docs/sanctum)
- [Laravel API Resources](https://laravel.com/docs/eloquent-resources)
- [CORS Configuration](https://laravel.com/docs/sanctum#cors-and-cookies)

