"""Full layout audit: reference vs generated template PDF."""
import fitz
import subprocess
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
REF = Path(r"C:\Users\Sya'ban\Downloads\RAIHAN TAUVIQUL HADY IFDAL.pdf")
OUT = ROOT / "storage" / "app" / "certificates" / "pdf" / "_audit_layout.pdf"
OUT.parent.mkdir(parents=True, exist_ok=True)
PT = 25.4 / 72.0

php = f"""
require '{ROOT / "vendor/autoload.php"}';
$app = require '{ROOT / "bootstrap/app.php"}';
$app->make(Illuminate\\Contracts\\Console\\Kernel::class)->bootstrap();
$svc = app(App\\Services\\CertificateService::class);
$ref = new ReflectionClass($svc);
$m = $ref->getMethod('imageBase64');
$m->setAccessible(true);
$qrM = $ref->getMethod('renderQrPng');
$qrM->setAccessible(true);
$wmM = $ref->getMethod('page2WatermarkBase64');
$wmM->setAccessible(true);
$logos = [
    'sidebar_bg' => $m->invoke($svc, 'sidebar-bg.png'),
    'kemnaker' => $m->invoke($svc, 'logo-kemnaker.png'),
    'kemnaker_mark' => $m->invoke($svc, 'logo-kemnaker-mark.png'),
    'ymt' => $m->invoke($svc, 'logo-ymt-creatorbase.png'),
    'vokasi' => $m->invoke($svc, 'logo-pelatihan-vokasi.png'),
    'indonesia_skills' => $m->invoke($svc, 'logo-indonesia-skills.png'),
    'skills_swoosh' => $m->invoke($svc, 'logo-skills-swoosh.png'),
    'siapkerja' => $m->invoke($svc, 'logo-siapkerja.png'),
    'page2_watermark' => $wmM->invoke($svc),
];
$qr = 'data:image/png;base64,' . base64_encode($qrM->invoke($svc, 'https://example.com/verify'));
$html = view('certificates.pdf', [
    'certificate' => (object)['certificate_number'=>'DM2209320301-968YMTCB','issued_at'=>\\Carbon\\Carbon::parse('2026-06-02')],
    'class' => (object)['end_date'=>\\Carbon\\Carbon::parse('2026-06-02')],
    'program' => (object)['name'=>'Digital Marketing dan Evaluasi Skema Digital Marketing'],
    'participant' => (object)['name'=>'Raihan Tauviqul Hady Ifdal'],
    'materials' => collect([
        (object)['title'=>'Menggunakan Perangkat Komputer','material_code'=>'J.63OPR00.001.2'],
        (object)['title'=>'Menggunakan Penelusur Situs Web (Web Browser)','material_code'=>'J.63OPR00.007.2'],
        (object)['title'=>'Merencanakan Riset Terhadap Sebuah Produk dan/atau Merek','material_code'=>'M.70MKT00.009.2'],
        (object)['title'=>'Mengolah Data Riset','material_code'=>'M.70MKT00.010.2'],
        (object)['title'=>'Menggunakan Media Sosial dan Aplikasi Daring (Online Tools)','material_code'=>'M.70MKT00.012.2'],
        (object)['title'=>'Mempersiapkan Konten Digital','material_code'=>'M.70MKT00.014.2'],
        (object)['title'=>'Mengembangkan Pengetahuan Produk','material_code'=>'M.70MKT00.033.2'],
        (object)['title'=>'Melaksanakan Kegiatan Analisis di Media Sosial dan Media Bisnis Digital','material_code'=>'M.70MKT00.013.2'],
        (object)['title'=>'Mengoptimalkan Pengelolaan Media Sosial dan Rencana Aplikasi Digital','material_code'=>'M.70MKT00.015.2'],
        (object)['title'=>'Melaksanakan Kegiatan Promosi Merek','material_code'=>'M.70MKT00.017.2'],
        (object)['title'=>'Melakukan Aktivitas Pemasaran Digital untuk Bisnis Ritel','material_code'=>'G.46RIT00.055.1'],
    ]),
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
$pdf = Barryvdh\\DomPDF\\Facade\\Pdf::loadHTML($html)->setPaper('a4','landscape')->setOption('dpi',200)->setOption('defaultFont','DejaVu Sans');
file_put_contents('{OUT.as_posix()}', $pdf->output());
echo 'OK';
"""
r = subprocess.run(["php", "-r", php], cwd=ROOT, capture_output=True, text=True)
if r.returncode != 0:
    print(r.stderr or r.stdout)
    sys.exit(1)


def extract(page):
    texts, imgs, lines = [], [], []
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") == 0:
            for line in block["lines"]:
                for span in line["spans"]:
                    t = span["text"].strip()
                    if not t:
                        continue
                    x0, y0, x1, y1 = span["bbox"]
                    texts.append({
                        "t": t[:70], "y": round(y0 * PT, 1), "x": round(x0 * PT, 1),
                        "fs": round(span.get("size", 0), 1),
                    })
        elif block.get("type") == 1:
            x0, y0, x1, y1 = block["bbox"]
            imgs.append({
                "y0": round(y0 * PT, 1), "y1": round(y1 * PT, 1),
                "x0": round(x0 * PT, 1), "x1": round(x1 * PT, 1),
            })
    for d in page.get_drawings():
        rect = d.get("rect")
        if not rect:
            continue
        r = fitz.Rect(rect)
        w, h = (r.x1 - r.x0) * PT, (r.y1 - r.y0) * PT
        if w > 200 and h > 100:
            lines.append({"y0": round(r.y0 * PT, 1), "y1": round(r.y1 * PT, 1),
                          "x0": round(r.x0 * PT, 1), "x1": round(r.x1 * PT, 1)})
    return texts, imgs, lines


ref_doc = fitz.open(REF)
gen_doc = fitz.open(OUT)

print("=== PAGE 1 TEXT DELTA (gen - ref) ===")
ref_t, _, _ = extract(ref_doc[0])
gen_t, gen_imgs, _ = extract(gen_doc[0])
ref_map = {x["t"][:40]: x for x in ref_t if len(x["t"]) > 8}
for g in gen_t:
    if len(g["t"]) < 8:
        continue
    key = next((k for k in ref_map if g["t"][:30] in k or k[:30] in g["t"]), None)
    if key:
        r = ref_map[key]
        dy, dx = g["y"] - r["y"], g["x"] - r["x"]
        flag = " ***" if abs(dy) > 1.5 or abs(dx) > 8 else ""
        print(f"y {dy:+5.1f} x {dx:+6.1f} | {g['t'][:55]}{flag}")

print("\n=== PAGE 1 IMAGES (ref vs gen) ===")
_, ref_imgs, _ = extract(ref_doc[0])
print("REF images:")
for i in ref_imgs:
    print(f"  y={i['y0']}-{i['y1']} x={i['x0']}-{i['x1']}")
print("GEN images:")
for i in gen_imgs:
    print(f"  y={i['y0']}-{i['y1']} x={i['x0']}-{i['x1']}")

print("\n=== PAGE 2 TABLE (ref vs gen) ===")
ref_t2, ref_i2, ref_l2 = extract(ref_doc[1])
gen_t2, gen_i2, gen_l2 = extract(gen_doc[1])
print(f"REF rows(text lines): {len(ref_t2)}  GEN: {len(gen_t2)}")
print(f"REF watermark imgs: {len(ref_i2)}  GEN: {len(gen_i2)}")
print(f"REF big rects: {ref_l2}  GEN: {gen_l2}")
if ref_t2:
    print(f"REF header y={ref_t2[0]['y']}  GEN header y={gen_t2[0]['y'] if gen_t2 else '?'}")
