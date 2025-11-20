# Testing Guide

VILT Canvas uses [Pest](https://pestphp.com) for testing, a modern PHP testing framework built on top of PHPUnit with a beautiful, expressive syntax.

## Running Tests

### Run All Tests

```bash
php artisan test
```

Or using the composer script:

```bash
composer run test
```

### Run Specific Test Files

Run a specific test file:

```bash
php artisan test tests/Feature/Auth/AuthenticationTest.php
```

### Run Tests with Filter

Filter tests by name:

```bash
php artisan test --filter="login screen can be rendered"
```

Filter by test file pattern:

```bash
php artisan test --filter=Authentication
```

### Run Tests with Coverage

Generate code coverage report:

```bash
php artisan test --coverage
```

For HTML coverage report:

```bash
php artisan test --coverage --min=80
```

This will generate a coverage report in `coverage/index.html`.

### Run Specific Test Suites

**Feature tests only:**
```bash
php artisan test tests/Feature
```

**Unit tests only:**
```bash
php artisan test tests/Unit
```

## Test Structure

### Directory Organization

```
tests/
├── Feature/              # Feature tests (integration tests)
│   ├── Auth/            # Authentication tests
│   ├── Profile/         # Profile management tests
│   ├── DashboardTest.php
│   └── ...
├── Unit/                # Unit tests
│   └── ExampleTest.php
├── Pest.php            # Pest configuration
└── TestCase.php        # Base test case
```

### Test Types

#### Feature Tests

Feature tests test your application from the user's perspective. They make HTTP requests to your application and assert the responses.

**Location:** `tests/Feature/`

**Example:**
```php
test('users can authenticate', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/');
    $this->assertAuthenticatedAs($user);
});
```

#### Unit Tests

Unit tests test individual units of code in isolation.

**Location:** `tests/Unit/`

**Example:**
```php
test('can calculate total', function () {
    $calculator = new Calculator();
    
    expect($calculator->add(2, 3))->toBe(5);
});
```

## Writing Tests

### Basic Test Structure

```php
test('description of what is being tested', function () {
    // Arrange: Set up test data
    $user = User::factory()->create();
    
    // Act: Perform the action
    $response = $this->actingAs($user)->get('/dashboard');
    
    // Assert: Verify the result
    $response->assertStatus(200);
});
```

### Using Factories

Pest works seamlessly with Laravel factories:

```php
test('user can view profile', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
    
    $this->actingAs($user);
    
    $response = $this->get('/profile');
    
    $response->assertInertia(fn ($page) => $page
        ->component('Profile/Edit')
        ->where('auth.user.name', 'John Doe')
    );
});
```

### Testing Inertia Responses

VILT Canvas uses Inertia.js, so you'll often test Inertia responses:

```php
test('dashboard renders correctly', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    $response = $this->get('/dashboard');
    
    $response->assertInertia(fn ($page) => $page
        ->component('Dashboard')
        ->has('auth.user')
        ->where('auth.user.id', $user->id)
    );
});
```

### Testing Authentication

```php
test('requires authentication', function () {
    $response = $this->get('/dashboard');
    
    $response->assertRedirect('/login');
});

test('authenticated user can access', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    $response = $this->get('/dashboard');
    
    $response->assertStatus(200);
});
```

### Testing Forms

```php
test('can update profile', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    $response = $this->put('/user/profile-information', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
    ]);
    
    $response->assertSessionHasNoErrors();
    
    expect($user->fresh())
        ->name->toBe('Jane Doe')
        ->email->toBe('jane@example.com');
});
```

### Testing Validation

```php
test('validates required fields', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    $response = $this->put('/user/profile-information', [
        'name' => '',
        'email' => 'invalid-email',
    ]);
    
    $response->assertSessionHasErrors(['name', 'email']);
});
```

### Using Datasets

Datasets allow you to run the same test with different data:

```php
test('validates email format', function (string $email, bool $valid) {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    $response = $this->put('/user/profile-information', [
        'name' => 'Test User',
        'email' => $email,
    ]);
    
    if ($valid) {
        $response->assertSessionHasNoErrors();
    } else {
        $response->assertSessionHasErrors(['email']);
    }
})->with([
    ['valid@example.com', true],
    ['invalid-email', false],
    ['another@test.com', true],
    ['not-an-email', false],
]);
```

## Test Patterns Used in VILT Canvas

### Authentication Tests

**File:** `tests/Feature/Auth/AuthenticationTest.php`

```php
test('users can authenticate', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/');
    $this->assertAuthenticatedAs($user);
});
```

### Profile Tests

**File:** `tests/Feature/Profile/ProfileInformationTest.php`

```php
test('profile information can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->put('/user/profile-information', [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    $response->assertSessionHasNoErrors();

    $user->refresh();

    expect($user->name)->toBe('Test User');
    expect($user->email)->toBe('test@example.com');
});
```

### Two-Factor Authentication Tests

**File:** `tests/Feature/Profile/TwoFactorAuthenticationTest.php`

```php
test('two factor authentication can be enabled', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($user);

    $response = $this->post('/user/two-factor-authentication', [
        'password' => 'password',
    ]);

    $response->assertSessionHasNoErrors();
    expect($user->fresh()->two_factor_secret)->not->toBeNull();
});
```

## Pest Configuration

The main Pest configuration is in `tests/Pest.php`:

```php
uses(TestCase::class, RefreshDatabase::class)->in('Feature');
```

This applies:
- `TestCase::class` - Base test case with Laravel helpers
- `RefreshDatabase::class` - Refreshes database before each test

## Best Practices

1. **Use Descriptive Test Names**
   ```php
   // Good
   test('users can authenticate with valid credentials')
   
   // Bad
   test('test login')
   ```

2. **Follow AAA Pattern**
   - **Arrange**: Set up test data
   - **Act**: Perform the action
   - **Assert**: Verify the result

3. **Use Factories**
   ```php
   // Good
   $user = User::factory()->create();
   
   // Bad
   $user = new User();
   $user->name = 'Test';
   $user->save();
   ```

4. **Test Edge Cases**
   - Invalid input
   - Missing data
   - Unauthorized access
   - Error conditions

5. **Keep Tests Independent**
   - Each test should be able to run in isolation
   - Don't rely on test execution order

6. **Use Appropriate Assertions**
   ```php
   // For Inertia responses
   $response->assertInertia(...);
   
   // For redirects
   $response->assertRedirect(...);
   
   // For status codes
   $response->assertStatus(200);
   
   // For validation errors
   $response->assertSessionHasErrors(['email']);
   ```

## Running Tests in CI/CD

For continuous integration, you can use:

```bash
php artisan test --parallel
```

This runs tests in parallel for faster execution.

## Coverage Goals

Aim for:
- **Feature tests**: 80%+ coverage of controllers and routes
- **Unit tests**: 90%+ coverage of business logic
- **Overall**: 75%+ code coverage

## Additional Resources

- [Pest Documentation](https://pestphp.com/docs)
- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [PHPUnit Assertions](https://phpunit.de/documentation.html)

