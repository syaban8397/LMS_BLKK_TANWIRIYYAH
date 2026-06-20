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
use ReflectionClass;

$service = app(CertificateService::class);
$ref = new ReflectionClass($service);
$logos = $ref->getMethod('certificateLogos');
$logos->setAccessible(true);
$logoData = $logos->invoke($service);
$fonts = $ref->getMethod('certificateFonts');
$fonts->setAccessible(true);
$fontData = $fonts->invoke($service);

$cases = [
    'peserta1' => [
        'participant' => 'PESERTA 1',
        'program' => 'Desain Graphics',
        'degree' => 'C.DS (CERTIFIED DESAIN GRAFIS)',
        'year' => '2027',
        'out' => __DIR__ . '/../storage/app/test-cert-peserta1.pdf',
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

    $qrMethod = $ref->getMethod('renderQrPng');
    $qrMethod->setAccessible(true);
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
        'logos' => $logoData,
        'fonts' => $fontData,
        'organization' => config('certificate.organization'),
        'organizationEn' => config('certificate.organization_en'),
        'directorName' => config('certificate.director_name'),
        'directorTitleLine1' => config('certificate.director_title_line1'),
        'directorTitleLine2' => config('certificate.director_title_line2'),
    ])->render();

    $pdf = Pdf::loadHTML($html)
        ->setPaper('a4', 'landscape')
        ->setOption('dpi', 200)
        ->setOption('defaultFont', 'Montserrat')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isFontSubsettingEnabled', true);

    file_put_contents($case['out'], $pdf->output());
    echo "Written: {$case['out']}\n";
}
