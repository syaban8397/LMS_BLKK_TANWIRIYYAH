<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRoleMassAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_cannot_be_changed_via_mass_assignment_fill(): void
    {
        $user = User::factory()->make();
        $this->assertSame('peserta', $user->role);

        $user->fill(['role' => 'admin']);

        $this->assertSame('peserta', $user->role);
    }
}
