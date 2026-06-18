<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'nik' => '3201010101010001',
            'phone' => '081234567890',
            'gender' => 'L',
            'birth_place' => 'Jakarta',
            'birth_date' => '2000-01-01',
            'address' => 'Jl. Test No. 1',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms_accepted' => '1',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login', absolute: false));
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'nik' => '3201010101010001',
            'approval_status' => 'pending',
        ]);
    }

    public function test_registration_requires_terms_acceptance(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('terms_accepted');
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }
}
