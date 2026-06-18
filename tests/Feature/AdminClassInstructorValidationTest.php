<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class AdminClassInstructorValidationTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_admin_cannot_assign_non_instructor_as_class_instructor(): void
    {
        $context = $this->createTrainingContext();
        $program = Program::create([
            'name' => 'Program Uji Validasi',
            'description' => 'Program uji validasi instruktur',
            'start_date' => now()->subMonth(),
            'end_date' => now()->addMonths(2),
            'status' => 'active',
            'capacity' => 10,
        ]);
        $peserta = User::factory()->create([
            'role' => 'peserta',
            'is_active' => true,
            'approval_status' => 'approved',
        ]);

        $response = $this->actingAs($context['admin'])->post(route('admin.classes.store'), [
            'program_id' => $program->id,
            'instructor_id' => $peserta->id,
            'title' => 'Kelas Uji Validasi',
            'description' => 'Deskripsi kelas uji.',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'quota' => 20,
            'status' => 'draft',
        ]);

        $response->assertSessionHasErrors('instructor_id');
    }
}
