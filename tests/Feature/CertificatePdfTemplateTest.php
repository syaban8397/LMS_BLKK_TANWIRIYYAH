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

        $ref = new \ReflectionClass($service);



        $logos = $ref->getMethod('certificateLogos');

        $logos->setAccessible(true);

        $logoData = $logos->invoke($service);



        $fonts = $ref->getMethod('certificateFonts');

        $fonts->setAccessible(true);

        $fontData = $fonts->invoke($service);



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

            'fonts' => $fontData,

            'organization' => config('certificate.organization'),

            'organizationEn' => config('certificate.organization_en'),

            'directorName' => config('certificate.director_name'),

            'directorTitleLine1' => config('certificate.director_title_line1'),

            'directorTitleLine2' => config('certificate.director_title_line2'),

        ])->render();



        $this->assertStringContainsString('p1-bg', $html);

        $this->assertStringContainsString("@font-face", $html);

        $this->assertStringContainsString('Montserrat', $html);

        $this->assertStringContainsString('field-mask', $html);

        $this->assertStringContainsString(e(strtoupper($context['participant']->name)), $html);

        $this->assertStringContainsString('Telah Berpartisipasi Pada Pelatihan Digital Marketing dan Evaluasi', $html);

        $this->assertStringContainsString('Skema Digital Marketing Tahun', $html);

        $this->assertStringContainsString('C.DM (CERTIFIED DIGITAL MARKETING)', $html);

        $this->assertStringContainsString($certificate->certificate_number, $html);

        $this->assertStringContainsString('Issued Date:', $html);

        $this->assertStringContainsString($material->title, $html);

        $this->assertStringContainsString('J.63OPR00.001.2', $html);

        $this->assertStringContainsString('MATERI PELATIHAN', $html);

        $this->assertStringContainsString('KODE UNIT', $html);

        $this->assertNotEmpty($logoData['page1_reference_bg'] ?? null);

        $this->assertNotEmpty($fontData['bold'] ?? null);

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


