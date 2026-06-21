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



        $programLines = $ref->getMethod('page1ProgramLines');
        $programLines->setAccessible(true);
        $programLineData = $programLines->invoke($service, $context['program'], $context['class']);

        $dynamic = $ref->getMethod('buildPage1DynamicLayers');
        $dynamic->setAccessible(true);
        $page1Dynamic = $dynamic->invoke(
            $service,
            $certificate,
            'C.DM (CERTIFIED DIGITAL MARKETING)',
            3,
            $programLineData
        );

        $page2 = $ref->getMethod('buildPage2DynamicLayers');
        $page2->setAccessible(true);
        $page2Dynamic = $page2->invoke($service, collect([$material]));

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
            'page1Masks' => $page1Dynamic['masks'],
            'page1Layers' => $page1Dynamic['layers'],
            'page2Layers' => $page2Dynamic['layers'],
            'programLines' => $programLineData,
            'hasProgramLine2' => isset($programLineData[1]),
            'organization' => config('certificate.organization'),
            'organizationEn' => config('certificate.organization_en'),
            'directorName' => config('certificate.director_name'),
            'directorTitleLine1' => config('certificate.director_title_line1'),
            'directorTitleLine2' => config('certificate.director_title_line2'),
        ])->render();

        $this->assertStringContainsString('p1-bg', $html);
        $this->assertStringContainsString('field-mask', $html);
        $this->assertStringContainsString('p1-layer', $html);
        $this->assertStringContainsString('p2-layer', $html);
        $this->assertStringContainsString('data:image/png;base64,', $html);
        $this->assertNotEmpty($logoData['page1_reference_bg'] ?? null);
        $this->assertNotEmpty($page1Dynamic['layers']);
        $this->assertNotEmpty($page2Dynamic['layers']);

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


