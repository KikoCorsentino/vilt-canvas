<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->component('Auth/Register'));
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => true,
    ]);

    $response->assertRedirect('/');
    $this->assertAuthenticated();

    expect(User::where('email', 'test@example.com')->exists())->toBeTrue();
    $user = User::where('email', 'test@example.com')->first();
    expect($user->name)->toBe('Test User');
    expect(Hash::check('password', $user->password))->toBeTrue();
});

test('registration with invalid data fails', function () {
    // Missing required fields
    $response = $this->post('/register', [
        'name' => '',
        'email' => '',
        'password' => '',
    ]);

    $response->assertSessionHasErrors(['name', 'email', 'password']);

    // Invalid email
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'invalid-email',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => true,
    ]);

    $response->assertSessionHasErrors(['email']);

    // Password mismatch
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'different-password',
        'terms' => true,
    ]);

    $response->assertSessionHasErrors(['password']);

    // Email already exists
    User::factory()->create(['email' => 'existing@example.com']);

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'existing@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => true,
    ]);

    $response->assertSessionHasErrors(['email']);
});

