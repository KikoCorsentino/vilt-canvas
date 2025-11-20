<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('password can be updated', function () {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
    ]);

    $this->actingAs($user);

    $response = $this->put('/user/password', [
        'current_password' => 'old-password',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect();

    $user->refresh();
    expect(Hash::check('new-password', $user->password))->toBeTrue();
    expect(Hash::check('old-password', $user->password))->toBeFalse();
});

test('correct password must be provided to update password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('current-password'),
    ]);

    $this->actingAs($user);

    $response = $this->put('/user/password', [
        'current_password' => 'wrong-password',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertSessionHasErrorsIn('updatePassword', ['current_password']);

    $user->refresh();
    expect(Hash::check('current-password', $user->password))->toBeTrue();
    expect(Hash::check('new-password', $user->password))->toBeFalse();
});

test('password update with invalid data fails', function () {
    $user = User::factory()->create([
        'password' => Hash::make('current-password'),
    ]);

    $this->actingAs($user);

    // Missing current password
    $response = $this->put('/user/password', [
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertSessionHasErrorsIn('updatePassword', ['current_password']);

    // Missing new password
    $response = $this->put('/user/password', [
        'current_password' => 'current-password',
    ]);

    $response->assertSessionHasErrorsIn('updatePassword', ['password']);

    // Password mismatch
    $response = $this->put('/user/password', [
        'current_password' => 'current-password',
        'password' => 'new-password',
        'password_confirmation' => 'different-password',
    ]);

    $response->assertSessionHasErrorsIn('updatePassword', ['password']);

    // Password too short
    $response = $this->put('/user/password', [
        'current_password' => 'current-password',
        'password' => 'short',
        'password_confirmation' => 'short',
    ]);

    $response->assertSessionHasErrorsIn('updatePassword', ['password']);
});

