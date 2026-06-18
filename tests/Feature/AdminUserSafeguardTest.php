<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class AdminUserSafeguardTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_admin_cannot_delete_themselves(): void
    {
        $context = $this->createTrainingContext();

        $response = $this->actingAs($context['admin'])->delete(
            route('admin.users.destroy', $context['admin'])
        );

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $context['admin']->id]);
    }

    public function test_admin_can_delete_peserta_user(): void
    {
        $context = $this->createTrainingContext();
        $peserta = User::factory()->create(['role' => 'peserta']);

        $response = $this->actingAs($context['admin'])->delete(
            route('admin.users.destroy', $peserta)
        );

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $peserta->id]);
    }

    public function test_admin_can_update_user_approval_status(): void
    {
        $context = $this->createTrainingContext();
        $pendingUser = User::factory()->create([
            'approval_status' => 'pending',
            'is_active' => false,
        ]);

        $response = $this->actingAs($context['admin'])->patch(
            route('admin.users.update-status', $pendingUser),
            ['approval_status' => 'approved']
        );

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $pendingUser->id,
            'approval_status' => 'approved',
            'is_active' => true,
        ]);
    }
}
