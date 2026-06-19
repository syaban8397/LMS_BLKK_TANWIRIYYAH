<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\ClassModel;
use App\Models\User;
use App\Support\SecureStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class CertificateDeleteTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_admin_can_delete_issued_certificate(): void
    {
        Storage::fake(SecureStorage::DISK);

        $context = $this->createTrainingContext();
        $certificate = $this->createCertificate($context, 'DM-DELETE-0001');

        Storage::disk(SecureStorage::DISK)->put($certificate->pdf_file, 'pdf-content');
        Storage::disk(SecureStorage::DISK)->put($certificate->qr_code, 'qr-content');

        $response = $this->actingAs($context['admin'])->delete(
            route('admin.certificates.destroy', [$context['class'], $certificate])
        );

        $response->assertRedirect(route('admin.certificates.show', $context['class']));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('certificates', ['id' => $certificate->id]);
        Storage::disk(SecureStorage::DISK)->assertMissing($certificate->pdf_file);
        Storage::disk(SecureStorage::DISK)->assertMissing($certificate->qr_code);
    }

    public function test_instructor_can_delete_certificate_for_own_class(): void
    {
        $context = $this->createTrainingContext();
        $certificate = $this->createCertificate($context, 'DM-DELETE-0002');

        $response = $this->actingAs($context['instructor'])->delete(
            route('instruktur.certificates.destroy', [$context['class'], $certificate])
        );

        $response->assertRedirect(route('instruktur.certificates.show', $context['class']));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('certificates', ['id' => $certificate->id]);
    }

    public function test_instructor_cannot_delete_certificate_from_other_class(): void
    {
        $context = $this->createTrainingContext();

        $otherInstructor = User::factory()->instruktur()->create();
        $otherClass = ClassModel::create([
            'program_id' => $context['program']->id,
            'instructor_id' => $otherInstructor->id,
            'code' => 'DM-0002',
            'title' => 'Kelas Digital Marketing B',
            'description' => 'Kelas uji lain',
            'start_date' => now()->subWeek(),
            'end_date' => now()->addMonth(),
            'quota' => 30,
            'status' => 'active',
        ]);

        $certificate = Certificate::create([
            'participant_id' => $context['participant']->id,
            'class_id' => $otherClass->id,
            'certificate_number' => 'DM-DELETE-0003',
            'final_score' => 85,
            'attendance_percentage' => 90,
            'qr_code' => 'certificates/qr/DM-DELETE-0003.png',
            'pdf_file' => 'certificates/pdf/DM-DELETE-0003.pdf',
            'issued_at' => now(),
        ]);

        $response = $this->actingAs($context['instructor'])->delete(
            route('instruktur.certificates.destroy', [$otherClass, $certificate])
        );

        $response->assertForbidden();
        $this->assertDatabaseHas('certificates', ['id' => $certificate->id]);
    }

    public function test_participant_cannot_delete_certificate(): void
    {
        $context = $this->createTrainingContext();
        $certificate = $this->createCertificate($context, 'DM-DELETE-0004');

        $response = $this->actingAs($context['participant'])->delete(
            route('admin.certificates.destroy', [$context['class'], $certificate])
        );

        $response->assertForbidden();
        $this->assertDatabaseHas('certificates', ['id' => $certificate->id]);
    }

    public function test_deleted_certificate_number_is_no_longer_verifiable(): void
    {
        $context = $this->createTrainingContext();
        $certificate = $this->createCertificate($context, 'DM-DELETE-0005');
        $number = $certificate->certificate_number;

        $this->actingAs($context['admin'])->delete(
            route('admin.certificates.destroy', [$context['class'], $certificate])
        );

        $response = $this->get(route('certificates.verify', $number));

        $response->assertOk();
        $response->assertSee(__('lms.certificate.verify_invalid'));
    }
}
