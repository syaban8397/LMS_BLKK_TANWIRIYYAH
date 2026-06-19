<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class CertificatePdfTemplateTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_certificate_pdf_view_renders_with_reference_assets(): void
    {
        $context = $this->createTrainingContext();
        $context['program']->update(['name' => 'Digital Marketing dan Evaluasi Skema Digital Marketing']);
        $material = $this->createMaterial($context);
        $material->update(['material_code' => 'J.63OPR00.001.2']);
        $certificate = $this->createCertificate($context, 'DM-TEST-0001');

        $service = app(\App\Services\CertificateService::class);
        $logos = (new \ReflectionClass($service))
            ->getMethod('certificateLogos');

        $logos->setAccessible(true);
        $logoData = $logos->invoke($service);

        $html = view('certificates.pdf', [
            'certificate' => $certificate,
            'class' => $context['class'],
            'program' => $context['program'],
            'participant' => $context['participant'],
            'materials' => collect([$material]),
            'degree' => 'C.DM (CERTIFIED DIGITAL MARKETING)',
            'validityYears' => 3,
            'trainingYear' => $context['class']->end_date->format('Y'),
            'qrDataUri' => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"></svg>'),
            'logos' => $logoData,
            'organization' => config('certificate.organization'),
            'organizationEn' => config('certificate.organization_en'),
            'directorName' => config('certificate.director_name'),
            'directorTitleLine1' => config('certificate.director_title_line1'),
            'directorTitleLine2' => config('certificate.director_title_line2'),
        ])->render();

        $this->assertStringNotContainsString('S<br>E<br>R', $html);
        $this->assertStringContainsString(e(strtoupper($context['participant']->name)), $html);
        $this->assertStringContainsString('This Certificate explains that :', $html);
        $this->assertStringContainsString('Organized by', $html);
        $this->assertStringContainsString(e(config('certificate.director_title_line1')), $html);
        $this->assertStringContainsString(e(config('certificate.director_title_line2')), $html);
        $this->assertStringContainsString('Telah Berpartisipasi Pada Pelatihan Digital Marketing dan Evaluasi', $html);
        $this->assertStringContainsString('Skema Digital Marketing Tahun', $html);
        $this->assertStringContainsString($material->title, $html);
        $this->assertStringContainsString('J.63OPR00.001.2', $html);
        $this->assertStringContainsString('Certified Number :', $html);
        $this->assertStringContainsString('Issued Date:', $html);
        $this->assertStringContainsString($certificate->certificate_number, $html);
        $this->assertStringNotContainsString(
            'Certified Number : ' . $certificate->certificate_number,
            $html
        );
        $numberPos = strpos($html, $certificate->certificate_number);
        $issuedPos = strpos($html, 'Issued Date:');
        $this->assertNotFalse($numberPos);
        $this->assertNotFalse($issuedPos);
        $this->assertLessThan($issuedPos, $numberPos, 'Nomor sertifikat harus di atas Issued Date (sesuai referensi)');
        $this->assertStringContainsString('#002d5b', $html);
        $this->assertStringContainsString('#d32f2f', $html);
        $this->assertStringContainsString('#1e40af', $html);
        $this->assertStringContainsString('Diverifikasi Oleh :', $html);
        $this->assertStringContainsString('Serta berhak atas Gelar Non-Akademik', $html);
        $this->assertStringContainsString('MATERI PELATIHAN', $html);
        $this->assertStringContainsString('KODE UNIT', $html);
        $this->assertStringContainsString('height: 13.8mm', $html);
        $this->assertStringContainsString('height: 13.75mm', $html);
        $this->assertStringContainsString('top: 31.8mm', $html);
        $this->assertStringContainsString('top: 153.2mm', $html);
        $this->assertStringContainsString('top: 168.5mm', $html);
        $this->assertStringContainsString('top: 184.7mm', $html);
        $this->assertStringContainsString('top: 189.5mm', $html);
        $this->assertStringContainsString('top: 194.2mm', $html);
        $this->assertStringContainsString('width: 63mm', $html);
        $this->assertStringContainsString('top: 68.1mm', $html);
        $this->assertNotEmpty($logoData['kemnaker'] ?? null);
        $this->assertNotEmpty($logoData['sidebar_bg'] ?? null);
    }

    public function test_certificate_download_filename_uses_participant_name(): void
    {
        $context = $this->createTrainingContext();
        $certificate = $this->createCertificate($context, 'DM-TEST-0002');
        $context['participant']->update(['name' => 'Raihan Tauviqul Hady Ifdal']);

        $filename = app(\App\Services\CertificateService::class)->downloadFilename($certificate->fresh());

        $this->assertSame('RAIHAN TAUVIQUL HADY IFDAL.pdf', $filename);
    }
}
