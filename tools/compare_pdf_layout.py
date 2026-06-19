"""Generate sample certificate PDF and compare text Y positions with reference."""
import fitz
import subprocess
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
REF = Path(r"C:\Users\Sya'ban\Downloads\RAIHAN TAUVIQUL HADY IFDAL.pdf")
OUT = ROOT / "storage" / "app" / "certificates" / "pdf" / "_layout_compare.pdf"
OUT.parent.mkdir(parents=True, exist_ok=True)

php = f"""
require '{ROOT / "vendor/autoload.php"}';
$app = require '{ROOT / "bootstrap/app.php"}';
$app->make(Illuminate\\Contracts\\Console\\Kernel::class)->bootstrap();
$svc = app(App\\Services\\CertificateService::class);
$ref = new ReflectionClass($svc);
$m = $ref->getMethod('imageBase64');
$m->setAccessible(true);
$logos = [
    'sidebar_bg' => $m->invoke($svc, 'sidebar-bg.png'),
    'kemnaker' => $m->invoke($svc, 'logo-kemnaker.png'),
    'kemnaker_mark' => $m->invoke($svc, 'logo-kemnaker-mark.png'),
    'ymt' => $m->invoke($svc, 'logo-ymt-creatorbase.png'),
    'vokasi' => $m->invoke($svc, 'logo-pelatihan-vokasi.png'),
    'skills_swoosh' => $m->invoke($svc, 'logo-skills-swoosh.png'),
    'siapkerja' => $m->invoke($svc, 'logo-siapkerja.png'),
    'page2_watermark' => $m->invoke($svc, 'page2-watermark.png'),
];
$qr = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"><rect width="100" height="100" fill="#000"/></svg>');
$html = view('certificates.pdf', [
    'certificate' => (object)['certificate_number'=>'DM2209320301-971YMTCB','issued_at'=>now()],
    'class' => (object)['end_date'=>now()],
    'program' => (object)['name'=>'Digital Marketing dan Evaluasi Skema Digital Marketing'],
    'participant' => (object)['name'=>'Raihan Tauviqul Hady Ifdal'],
    'materials' => collect([(object)['title'=>'Menggunakan Perangkat Komputer','material_code'=>'J.63OPR00.001.2']]),
    'degree' => 'C.DM (CERTIFIED DIGITAL MARKETING)',
    'validityYears' => 3,
    'trainingYear' => '2026',
    'qrDataUri' => $qr,
    'logos' => $logos,
    'organization' => config('certificate.organization'),
    'organizationEn' => config('certificate.organization_en'),
    'directorName' => config('certificate.director_name'),
    'directorTitleLine1' => config('certificate.director_title_line1'),
    'directorTitleLine2' => config('certificate.director_title_line2'),
])->render();
$pdf = Barryvdh\\DomPDF\\Facade\\Pdf::loadHTML($html)->setPaper('a4','landscape')->setOption('dpi',200);
file_put_contents('{OUT.as_posix()}', $pdf->output());
echo 'OK';
"""

result = subprocess.run(["php", "-r", php], cwd=ROOT, capture_output=True, text=True)
if result.returncode != 0:
    print(result.stderr or result.stdout)
    sys.exit(1)

PT_TO_MM = 25.4 / 72.0


def extract_labels(path):
    doc = fitz.open(path)
    page = doc[0]
    labels = {}
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") != 0:
            continue
        for line in block["lines"]:
            for span in line["spans"]:
                t = span["text"].strip()
                if not t:
                    continue
                y = round(span["bbox"][1] * PT_TO_MM, 1)
                labels[t[:80]] = y
    return labels


ref = extract_labels(REF)
gen = extract_labels(OUT)

needles = [
    "SERTIFIKAT INI MENERANGKAN BAHWA",
    "RAIHAN TAUVIQUL HADY IFDAL",
    "Diverifikasi Oleh",
    "Certified Number",
    "Zaid Ahmad",
    "Issued Date",
]

print("=== PAGE 1 Y-position delta (generated - reference) mm ===")
for needle in needles:
    rk = next((k for k in ref if needle in k), None)
    gk = next((k for k in gen if needle in k), None)
    if rk and gk:
        d = gen[gk] - ref[rk]
        print(f"{needle:36} ref={ref[rk]:6.1f} gen={gen[gk]:6.1f} delta={d:+.1f}")
    else:
        print(f"{needle:36} MISSING ref={bool(rk)} gen={bool(gk)}")
