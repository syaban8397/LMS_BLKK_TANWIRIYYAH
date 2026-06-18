<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Support\PasswordResetToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_screen_can_be_rendered(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
    }

    public function test_user_can_verify_with_matching_email_and_nik(): void
    {
        $user = User::factory()->create([
            'nik' => '3201010101010001',
            'is_active' => true,
            'approval_status' => 'approved',
        ]);

        $response = $this->post(route('password.verify'), [
            'email' => $user->email,
            'nik' => $user->nik,
        ]);

        $response->assertSessionHas('popup_success');

        $token = session('reset_token');
        $this->assertIsString($token);
        $this->assertSame($user->id, PasswordResetToken::userIdFor($token));
    }

    public function test_verify_fails_when_email_and_nik_do_not_match(): void
    {
        User::factory()->create([
            'email' => 'a@example.com',
            'nik' => '1111111111111111',
            'is_active' => true,
            'approval_status' => 'approved',
        ]);

        User::factory()->create([
            'email' => 'b@example.com',
            'nik' => '2222222222222222',
            'is_active' => true,
            'approval_status' => 'approved',
        ]);

        $response = $this->post(route('password.verify'), [
            'email' => 'a@example.com',
            'nik' => '2222222222222222',
        ]);

        $response->assertSessionHas('popup_error');
        $response->assertSessionHas('popup_error', __('lms.auth_popup.verify_failed_generic'));
        $this->assertNull(session('reset_token'));
    }

    public function test_verify_uses_same_generic_error_for_unknown_email(): void
    {
        $response = $this->post(route('password.verify'), [
            'email' => 'unknown@example.com',
            'nik' => '3201010101019999',
        ]);

        $response->assertSessionHas('popup_error', __('lms.auth_popup.verify_failed_generic'));
    }

    public function test_reset_password_screen_requires_verified_session(): void
    {
        $response = $this->get(route('password.form'));

        $response->assertRedirect(route('password.request'));
    }

    public function test_reset_password_screen_rejects_expired_token(): void
    {
        $user = User::factory()->create([
            'nik' => '3201010101010003',
            'is_active' => true,
            'approval_status' => 'approved',
        ]);

        $token = PasswordResetToken::create($user->id);
        Cache::forget('password_reset:' . $token);

        $response = $this->withSession(['reset_token' => $token])
            ->get(route('password.form'));

        $response->assertRedirect(route('password.request'));
    }

    public function test_password_can_be_reset_after_verification(): void
    {
        $user = User::factory()->create([
            'nik' => '3201010101010002',
            'is_active' => true,
            'approval_status' => 'approved',
        ]);

        $this->post(route('password.verify'), [
            'email' => $user->email,
            'nik' => $user->nik,
        ]);

        $token = session('reset_token');

        $response = $this->post(route('password.reset.custom'), [
            'reset_token' => $token,
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'));

        $this->assertTrue(
            \Illuminate\Support\Facades\Hash::check('new-password-123', $user->fresh()->password)
        );

        $this->assertNull(session('reset_token'));
        $this->assertNull(PasswordResetToken::userIdFor($token));
    }
}
