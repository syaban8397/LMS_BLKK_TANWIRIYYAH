<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Certificate;
use App\Models\ClassModel;
use App\Models\Material;
use App\Models\Program;
use App\Models\User;
use App\Services\CertificateService;
use Barryvdh\DomPDF\Facade\Pdf;

$service = app(CertificateService::class);
$ref = new ReflectionClass($service);
$logosMethod = $ref->getMethod('certificateLogos');
$logosMethod->setAccessible(true);
$programLinesMethod = $ref->getMethod('page1ProgramLines');
$programLinesMethod->setAccessible(true);
        $dynamicMethod = $ref->getMethod('buildPage1DynamicLayers');
        $dynamicMethod->setAccessible(true);
        $page2Method = $ref->getMethod('buildPage2DynamicLayers');
        $page2Method->setAccessible(true);
$qrMethod = $ref->getMethod('renderQrPng');
$qrMethod->setAccessible(true);

$cases = [
    'peserta1' => [
        'participant' => 'PESERTA 1',
        'program' => 'Desain Graphics',
        'degree' => 'C.DS (CERTIFIED DESAIN GRAFIS)',
        'year' => '2027',
        'out' => __DIR__ . '/../storage/app/test-cert-peserta1.pdf',
    ],
    'raihan' => [
        'participant' => 'RAIHAN TAUVIQUL HADY IFDAL',
        'program' => 'Digital Marketing dan Evaluasi Skema Digital Marketing',
        'degree' => 'C.DM (CERTIFIED DIGITAL MARKETING)',
        'year' => '2026',
        'out' => __DIR__ . '/../storage/app/test-cert-raihan.pdf',
    ],
];

foreach ($cases as $case) {
    $participant = new User(['name' => $case['participant']]);
    $program = new Program(['name' => $case['program'], 'validity_years' => 3]);
    $class = new ClassModel(['end_date' => now()->setDate((int) $case['year'], 6, 21)]);
    $class->setRelation('program', $program);

    $certificate = new Certificate([
        'certificate_number' => 'DE0100032372-971YMTCB',
        'issued_at' => now()->setDate(2026, 6, 21),
    ]);
    $certificate->setRelation('participant', $participant);

    $materials = collect([
        new Material(['title' => 'Test', 'material_code' => 'J.63OPR00.001.2', 'meeting_number' => 1]),
    ]);

    $programLines = $programLinesMethod->invoke($service, $program, $class);
    $page1Dynamic = $dynamicMethod->invoke($service, $certificate, $case['degree'], 3, $programLines);
    $page2Dynamic = $page2Method->invoke($service, $materials);
    $qrPng = $qrMethod->invoke($service, 'https://example.com/verify');

    $html = view('certificates.pdf', [
        'certificate' => $certificate,
        'class' => $class,
        'program' => $program,
        'participant' => $participant,
        'materials' => $materials,
        'degree' => $case['degree'],
        'validityYears' => 3,
        'trainingYear' => $case['year'],
        'qrDataUri' => 'data:image/png;base64,' . base64_encode($qrPng),
        'logos' => $logosMethod->invoke($service),
        'page1Masks' => $page1Dynamic['masks'],
        'page1Layers' => $page1Dynamic['layers'],
        'page2Layers' => $page2Dynamic['layers'],
        'programLines' => $programLines,
        'hasProgramLine2' => isset($programLines[1]),
        'organization' => config('certificate.organization'),
        'organizationEn' => config('certificate.organization_en'),
        'directorName' => config('certificate.director_name'),
        'directorTitleLine1' => config('certificate.director_title_line1'),
        'directorTitleLine2' => config('certificate.director_title_line2'),
    ])->render();

    $pdf = Pdf::loadHTML($html)
        ->setPaper('a4', 'landscape')
        ->setOption('dpi', 200)
        ->setOption('defaultFont', 'montserrat')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isFontSubsettingEnabled', false);

    file_put_contents($case['out'], $pdf->output());
    echo "Written: {$case['out']}\n";
}
