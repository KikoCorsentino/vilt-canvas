<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('user account can be deleted', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $this->actingAs($user);

    $response = $this->delete('/user', [
        'password' => 'password',
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect('/');

    expect(User::find($user->id))->toBeNull();
    $this->assertGuest();
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $this->actingAs($user);

    $response = $this->delete('/user', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors(['password']);

    expect(User::find($user->id))->not->toBeNull();
    $this->assertAuthenticatedAs($user);
});

test('user data is removed after deletion', function () {
    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    $userId = $user->id;
    $userEmail = $user->email;

    $this->actingAs($user);

    $response = $this->delete('/user', [
        'password' => 'password',
    ]);

    $response->assertSessionHasNoErrors();

    // Verify user is deleted
    expect(User::find($userId))->toBeNull();
    expect(User::where('email', $userEmail)->exists())->toBeFalse();
});

test('password is required to delete account', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $this->actingAs($user);

    $response = $this->delete('/user', []);

    $response->assertSessionHasErrors(['password']);

    expect(User::find($user->id))->not->toBeNull();
});

