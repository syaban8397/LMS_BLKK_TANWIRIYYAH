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

        $this->assertStringContainsString('S<br>E<br>R', $html);
        $this->assertStringContainsString('T<br>R<br>A<br>I<br>N<br>I<br>N<br>G', $html);
        $this->assertStringContainsString(e(strtoupper($context['participant']->name)), $html);
        $this->assertStringContainsString($material->title, $html);
        $this->assertStringContainsString('J.63OPR00.001.2', $html);
        $this->assertStringContainsString($certificate->certificate_number, $html);
        $this->assertNotEmpty($logoData['kemnaker'] ?? null);
        $this->assertNotEmpty($logoData['sidebar_bg'] ?? null);
    }
}
