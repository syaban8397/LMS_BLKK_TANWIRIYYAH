<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecureFileAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_secure_photo_route_requires_authentication(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('secure.photos.show', $user));

        $response->assertRedirect(route('login'));
    }

    public function test_deactivated_user_is_logged_out_on_protected_route(): void
    {
        $user = User::factory()->create([
            'is_active' => false,
            'approval_status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
