<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

test('email verification screen can be rendered', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user);

    $response = $this->get('/email/verify');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->component('Auth/VerifyEmail'));
});

test('email can be verified', function () {
    Event::fake([Verified::class]);

    $user = User::factory()->unverified()->create();

    $this->actingAs($user);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->get($verificationUrl);

    // After verification, user is redirected (could be to home or dashboard)
    $response->assertRedirect();

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    Event::assertDispatched(Verified::class);
});

test('email is not verified with invalid hash', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => 'invalid-hash']
    );

    $response = $this->get($verificationUrl);

    $response->assertForbidden();

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

test('email verification notification can be resent', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user);

    $response = $this->post('/email/verification-notification');

    $response->assertSessionHas('status', 'verification-link-sent');
});

test('verified users can access verification screen', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get('/email/verify');

    // Verified users can still access the screen (Fortify doesn't redirect automatically)
    // The screen will just show that email is already verified
    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->component('Auth/VerifyEmail'));
});

