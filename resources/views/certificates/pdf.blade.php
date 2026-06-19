@php
    $validityWordId = match ((int) $validityYears) {
        1 => 'Satu', 2 => 'Dua', 3 => 'Tiga', 4 => 'Empat', 5 => 'Lima',
        default => (string) $validityYears,
    };
    $validityWordEn = match ((int) $validityYears) {
        1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five',
        default => (string) $validityYears,
    };
    $trainingYear = $class->end_date->format('Y');
    $programName = $program->name;

    if (preg_match('/^(.+?)\s+(Skema\s+.+)$/iu', $programName, $skemaMatch)) {
        $programLines = [
            'Telah Berpartisipasi Pada Pelatihan ' . trim($skemaMatch[1]),
            trim($skemaMatch[2]) . ' Tahun ' . $trainingYear,
        ];
    } else {
        $programFull = 'Telah Berpartisipasi Pada Pelatihan ' . $programName . ' Tahun ' . $trainingYear;
        $programLines = [$programFull];
        if (preg_match('/^(Telah Berpartisipasi Pada Pelatihan .+?) (Skema .+ Tahun \d{4})$/u', $programFull, $matches)) {
            $programLines = [trim($matches[1]), trim($matches[2])];
        }
    }

    $orgParts = preg_split('/\s-\s/', $organization, 2);
    $hasOrgLine2 = is_array($orgParts) && count($orgParts) === 2;
    $orgLine1Html = $hasOrgLine2
        ? '<span class="txt-org-prefix">yang diselenggarakan oleh </span><span class="txt-org-name">' . e(trim($orgParts[0])) . ' -</span>'
        : '<span class="txt-org-prefix">yang diselenggarakan oleh </span><span class="txt-org-name">' . e($organization) . '</span>';
    $orgLine2Html = $hasOrgLine2
        ? '<span class="txt-org-name">' . e(trim($orgParts[1])) . '</span>'
        : null;

    $maxMaterialRows = 11;
    $materialCount = $materials->count();
    $hasProgramLine2 = isset($programLines[1]) && trim($programLines[1]) !== '';

    // Koordinat mm diekstrak langsung dari RAIHAN TAUVIQUL HADY IFDAL.pdf (PyMuPDF)
    // Dikompensasi offset render DomPDF (~1.1mm body, ~2.3mm meta kanan)
    $ref = [
        'sidebar_w'    => 63.0,
        'content_l'    => 63.0,
        'content_w'    => 234.0,
        'divider_top'  => 30.0,
        'intro_id'     => 31.8,
        'intro_en'     => 38.1,
        'name'         => 46.8,
        'org_line1'    => 60.7,
        'org_line2'    => 68.1,
        'program'      => 78.5,
        'program_2'    => 85.9,
        'en_org'       => 94.8,
        'non_akademik' => 101.9,
        'en_degree'    => 109.7,
        'degree'       => 121.2,
        'validity'     => 133.4,
        'validity_en'  => 141.2,
        'verify'       => 153.2,
        'qr_top'       => 168.5,
        'qr_size'      => 20.6,
        'sign_name'    => 185.4,
        'sign_title1'  => 192.0,
        'sign_title2'  => 198.2,
        'meta_number'  => 184.7,
        'meta_value'   => 189.5,
        'meta_issued'  => 194.2,
        'p2_box_top'   => 21.6,
        'p2_box_left'  => 10.6,
        'p2_box_w'     => 276.3,
        'p2_box_h'     => 165.0,
        'p2_wm_left'   => 64.0,
        'p2_wm_top'    => 20.5,
        'p2_wm_w'      => 169.1,
        'logo_1' => ['l' => 72.9, 't' => 12.2, 'w' => 43.9, 'h' => 17.7, 'img_h' => 13],
        'logo_2' => ['l' => 120.1, 't' => 11.0, 'w' => 46.3, 'h' => 17.5, 'img_h' => 11],
        'logo_3' => ['l' => 171.6, 't' => 15.1, 'w' => 31.5, 'h' => 10.1, 'img_h' => 10],
        'logo_4' => ['l' => 206.2, 't' => 15.9, 'w' => 20.0, 'h' => 10.0, 'img_h' => 10],
        'logo_5' => ['l' => 227.5, 't' => 9.7, 'w' => 15.4, 'h' => 16.1, 'img_h' => 11],
        'logo_6' => ['l' => 242.9, 't' => 10.7, 'w' => 33.6, 'h' => 18.8, 'img_h' => 11],
    ];

    // QR center X referensi: (171.7 + 192.3) / 2 = 182.0mm
    $ref['qr_left'] = 182.0 - ($ref['qr_size'] / 2);

    $singleLineShift = $hasProgramLine2 ? 0 : 7.4;
    $layout = [
        'intro_id'     => $ref['intro_id'],
        'intro_en'     => $ref['intro_en'],
        'name'         => $ref['name'],
        'org_line1'    => $ref['org_line1'],
        'org_line2'    => $ref['org_line2'],
        'program'      => $ref['program'],
        'program_2'    => $hasProgramLine2 ? $ref['program_2'] : null,
        'en_org'       => $ref['en_org'] - $singleLineShift,
        'non_akademik' => $ref['non_akademik'] - $singleLineShift,
        'en_degree'    => $ref['en_degree'] - $singleLineShift,
        'degree'       => $ref['degree'] - $singleLineShift,
        'validity'     => $ref['validity'] - $singleLineShift,
        'validity_en'  => $ref['validity_en'] - $singleLineShift,
        'verify'       => $ref['verify'],
        'qr_top'       => $ref['qr_top'],
        'qr_left'      => $ref['qr_left'],
        'qr_size'      => $ref['qr_size'],
        'sign_name'    => $ref['sign_name'],
        'sign_title1'  => $ref['sign_title1'],
        'sign_title2'  => $ref['sign_title2'],
        'meta_number'  => $ref['meta_number'],
        'meta_value'   => $ref['meta_value'],
        'meta_issued'  => $ref['meta_issued'],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sertifikat - {{ $participant->name }}</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

@page {
    size: 297mm 210mm;
    margin: 0;
}

body {
    font-family: 'DejaVu Sans', Arial, sans-serif;
    color: #111827;
    width: 297mm;
    margin: 0;
    padding: 0;
}

.page {
    position: relative;
    width: 297mm;
    height: 210mm;
    overflow: hidden;
    page-break-after: always;
    background: #ffffff;
}
.page-last { page-break-after: auto; }

.abs { position: absolute; }

/* PAGE 1 — SIDEBAR (referensi: 63mm) */
.p1-sidebar {
    left: 0;
    top: 0;
    width: {{ $ref['sidebar_w'] }}mm;
    height: 210mm;
    background-color: #002d5b;
    background-repeat: no-repeat;
    background-size: {{ $ref['sidebar_w'] }}mm 210mm;
    background-position: top left;
    z-index: 1;
}

.txt-org-prefix { font-weight: normal; }
.txt-org-name { font-weight: bold; }

.p1-sidebar-text {
    display: none;
}

/* PAGE 1 — LOGO BAR (posisi dari image blocks referensi) */
.p1-logo {
    text-align: center;
    overflow: hidden;
}
.p1-logo img,
.p1-logo .logo-indonesia-text {
    display: inline-block;
    vertical-align: middle;
    line-height: normal;
    max-width: 100%;
}

.logo-indonesia-text {
    font-size: 10.1pt;
    font-weight: bold;
    color: #111827;
    line-height: 1.05;
    text-align: center;
    padding-top: 0;
}

.p1-divider {
    left: {{ $ref['content_l'] }}mm;
    top: {{ $ref['divider_top'] }}mm;
    width: {{ $ref['content_w'] }}mm;
    height: 0;
    border: none;
    border-top: 0.5px solid #b8c4d4;
}

/* PAGE 1 — BODY */
.p1-text,
.p1-center,
.footer-meta {
    z-index: 5;
}

.p1-text {
    left: {{ $ref['content_l'] }}mm;
    width: {{ $ref['content_w'] }}mm;
    text-align: center;
}

.p1-center {
    left: {{ $ref['content_l'] }}mm;
    width: {{ $ref['content_w'] }}mm;
    text-align: center;
}

.txt-intro-id {
    font-size: 10.5pt;
    font-weight: bold;
    color: #002d5b;
    letter-spacing: 0.2px;
}
.txt-intro-en {
    font-size: 8.5pt;
    font-style: italic;
    color: #757575;
}
.txt-name {
    font-size: 25pt;
    font-weight: bold;
    color: #000000;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    line-height: 1.05;
}
.txt-org {
    font-size: 10.5pt;
    font-weight: normal;
    color: #002d5b;
    line-height: 1.45;
    padding: 0 6mm;
}
.txt-program {
    font-size: 10.5pt;
    font-weight: bold;
    color: #002d5b;
    line-height: 1.45;
    padding: 0 6mm;
}
.txt-program-2 {
    font-size: 10.5pt;
    font-weight: bold;
    color: #002d5b;
    line-height: 1.45;
    padding: 0 6mm;
}
.txt-en {
    font-size: 8.5pt;
    font-style: italic;
    color: #757575;
    line-height: 1.35;
}
.txt-non-akademik {
    font-size: 10.5pt;
    font-weight: bold;
    color: #002d5b;
}
.txt-degree {
    font-size: 17pt;
    font-weight: bold;
    color: #d32f2f;
    letter-spacing: 0.3px;
    line-height: 1.15;
}
.txt-validity {
    font-size: 10.5pt;
    color: #002d5b;
    font-weight: bold;
}
.txt-validity-en {
    font-size: 8.5pt;
    font-style: italic;
    color: #757575;
}

.lbl-verify {
    font-size: 10.5pt;
    font-weight: bold;
    color: #002d5b;
    line-height: 1.2;
}

.qr-wrap {
    z-index: 6;
}
.qr-img {
    width: 20.6mm;
    height: 20.6mm;
    display: block;
}
.qr-mark {
    position: absolute;
    top: 6.8mm;
    left: 6.8mm;
    width: 7mm;
    height: 7mm;
}
.qr-mark img {
    width: 7mm;
    height: 7mm;
    display: block;
}

.sign-name {
    font-size: 12.5pt;
    font-weight: bold;
    color: #000000;
    line-height: 1.25;
}
.sign-title {
    font-size: 12.5pt;
    font-weight: normal;
    color: #000000;
    line-height: 1.25;
}

.footer-meta {
    right: 8mm;
    text-align: right;
    font-size: 10pt;
    font-weight: bold;
    color: #1e40af;
    line-height: 1.55;
    z-index: 5;
}
.footer-meta-line {
    white-space: nowrap;
}

/* PAGE 2 — MATERI */
.p2-wrap {
    left: 0;
    top: 0;
    width: 297mm;
    height: 210mm;
}
.p2-watermark {
    z-index: 0;
}
.p2-box {
    border: 2px solid #111111;
    overflow: hidden;
    z-index: 2;
    position: absolute;
    background: transparent;
}
.p2-table-wrap {
    position: relative;
    z-index: 2;
    width: 100%;
    height: 100%;
}
.p2-table {
    width: 100%;
    height: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}
.p2-table th,
.p2-table td {
    border: 1px solid #111111;
    vertical-align: middle;
    padding: 1mm 2mm;
}
.p2-table th {
    font-weight: bold;
    text-align: center;
    font-size: 12pt;
    height: 13.8mm;
    background: transparent;
    letter-spacing: 0.3px;
    border-bottom-width: 1.5px;
}
.p2-table td { height: 13.75mm; font-size: 11pt; background: transparent; }
.p2-no  { width: 14mm; text-align: center; font-size: 12pt; }
.p2-title { text-align: left; padding-left: 3mm; font-size: 11pt; }
.p2-code { width: 52mm; text-align: center; font-size: 11pt; }
</style>
</head>
<body>

<div class="page">

    <div class="abs p1-sidebar" @if(!empty($logos['sidebar_bg'])) style="background-image: url('data:image/png;base64,{{ $logos['sidebar_bg'] }}');" @endif></div>

    @if(empty($logos['sidebar_bg']))
    <div class="abs p1-sidebar-text" style="display:block;left:0;top:0;width:{{ $ref['sidebar_w'] }}mm;height:210mm;z-index:2;">
        <table style="width:{{ $ref['sidebar_w'] }}mm;height:210mm;border-collapse:collapse;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="vertical-align:middle;text-align:center;color:#fff;font-size:21pt;font-weight:bold;">SERTIFIKAT</td>
            </tr>
        </table>
    </div>
    @endif

    <div class="abs p1-logo p1-logo-1" style="left: {{ $ref['logo_1']['l'] }}mm; top: {{ $ref['logo_1']['t'] }}mm; width: {{ $ref['logo_1']['w'] }}mm; height: {{ $ref['logo_1']['h'] }}mm; line-height: {{ $ref['logo_1']['h'] }}mm;">
        @if(!empty($logos['kemnaker']))
            <img src="data:image/png;base64,{{ $logos['kemnaker'] }}" style="width:{{ $ref['logo_1']['w'] }}mm;height:{{ $ref['logo_1']['h'] }}mm;" alt="">
        @endif
    </div>
    <div class="abs p1-logo p1-logo-2" style="left: {{ $ref['logo_2']['l'] }}mm; top: {{ $ref['logo_2']['t'] }}mm; width: {{ $ref['logo_2']['w'] }}mm; height: {{ $ref['logo_2']['h'] }}mm; line-height: {{ $ref['logo_2']['h'] }}mm;">
        @if(!empty($logos['ymt']))
            <img src="data:image/png;base64,{{ $logos['ymt'] }}" style="width:{{ $ref['logo_2']['w'] }}mm;height:{{ $ref['logo_2']['h'] }}mm;" alt="">
        @endif
    </div>
    <div class="abs p1-logo p1-logo-3" style="left: {{ $ref['logo_3']['l'] }}mm; top: {{ $ref['logo_3']['t'] }}mm; width: {{ $ref['logo_3']['w'] }}mm; height: {{ $ref['logo_3']['h'] }}mm; line-height: {{ $ref['logo_3']['h'] }}mm;">
        @if(!empty($logos['vokasi']))
            <img src="data:image/png;base64,{{ $logos['vokasi'] }}" style="width:{{ $ref['logo_3']['w'] }}mm;height:{{ $ref['logo_3']['h'] }}mm;" alt="">
        @endif
    </div>
    <div class="abs p1-logo p1-logo-4" style="left: {{ $ref['logo_4']['l'] }}mm; top: {{ $ref['logo_4']['t'] }}mm; width: {{ $ref['logo_4']['w'] }}mm; height: {{ $ref['logo_4']['h'] }}mm; line-height: {{ $ref['logo_4']['h'] }}mm;">
        @if(!empty($logos['indonesia_skills']))
            <img src="data:image/png;base64,{{ $logos['indonesia_skills'] }}" style="width:{{ $ref['logo_4']['w'] }}mm;height:{{ $ref['logo_4']['h'] }}mm;" alt="">
        @else
            <div class="logo-indonesia-text">Indonesia<br>Skills</div>
        @endif
    </div>
    <div class="abs p1-logo p1-logo-5" style="left: {{ $ref['logo_5']['l'] }}mm; top: {{ $ref['logo_5']['t'] }}mm; width: {{ $ref['logo_5']['w'] }}mm; height: {{ $ref['logo_5']['h'] }}mm; line-height: {{ $ref['logo_5']['h'] }}mm;">
        @if(!empty($logos['skills_swoosh']))
            <img src="data:image/png;base64,{{ $logos['skills_swoosh'] }}" style="width:{{ $ref['logo_5']['w'] }}mm;height:{{ $ref['logo_5']['h'] }}mm;" alt="">
        @elseif(!empty($logos['blkk_mark']))
            <img src="data:image/png;base64,{{ $logos['blkk_mark'] }}" style="width:{{ $ref['logo_5']['w'] }}mm;height:{{ $ref['logo_5']['h'] }}mm;" alt="">
        @endif
    </div>
    <div class="abs p1-logo p1-logo-6" style="left: {{ $ref['logo_6']['l'] }}mm; top: {{ $ref['logo_6']['t'] }}mm; width: {{ $ref['logo_6']['w'] }}mm; height: {{ $ref['logo_6']['h'] }}mm; line-height: {{ $ref['logo_6']['h'] }}mm;">
        @if(!empty($logos['siapkerja']))
            <img src="data:image/png;base64,{{ $logos['siapkerja'] }}" style="width:{{ $ref['logo_6']['w'] }}mm;height:{{ $ref['logo_6']['h'] }}mm;" alt="">
        @endif
    </div>

    <hr class="abs p1-divider">

    <div class="abs p1-text txt-intro-id" style="top: {{ $layout['intro_id'] }}mm;">SERTIFIKAT INI MENERANGKAN BAHWA :</div>
    <div class="abs p1-text txt-intro-en" style="top: {{ $layout['intro_en'] }}mm;">This Certificate explains that :</div>

    <div class="abs p1-text txt-name" style="top: {{ $layout['name'] }}mm;">{{ strtoupper($participant->name) }}</div>

    <div class="abs p1-text txt-org" style="top: {{ $layout['org_line1'] }}mm;">{!! $orgLine1Html !!}</div>
    @if($orgLine2Html)
        <div class="abs p1-text txt-org" style="top: {{ $layout['org_line2'] }}mm;">{!! $orgLine2Html !!}</div>
    @endif

    <div class="abs p1-text txt-program" style="top: {{ $layout['program'] }}mm;">{{ $programLines[0] }}</div>
    @if($hasProgramLine2)
        <div class="abs p1-text txt-program-2" style="top: {{ $layout['program_2'] }}mm;">{{ $programLines[1] }}</div>
    @endif

    <div class="abs p1-text txt-en" style="top: {{ $layout['en_org'] }}mm;">Organized by {{ $organizationEn }}</div>

    <div class="abs p1-text txt-non-akademik" style="top: {{ $layout['non_akademik'] }}mm;">Serta berhak atas Gelar Non-Akademik</div>
    <div class="abs p1-text txt-en" style="top: {{ $layout['en_degree'] }}mm;">As well as the rights to Non-Academic Degree</div>

    <div class="abs p1-text txt-degree" style="top: {{ $layout['degree'] }}mm;">{{ $degree }}</div>

    <div class="abs p1-text txt-validity" style="top: {{ $layout['validity'] }}mm;">
        Sertifikat ini berlaku untuk : {{ $validityYears }} ({{ $validityWordId }}) Tahun
    </div>
    <div class="abs p1-text txt-validity-en" style="top: {{ $layout['validity_en'] }}mm;">
        This Certificate is valid for {{ $validityYears }} ({{ $validityWordEn }}) years
    </div>

    <div class="abs p1-center lbl-verify" style="top: {{ $layout['verify'] }}mm;">Diverifikasi Oleh :</div>

    <div class="abs qr-wrap" style="top: {{ $layout['qr_top'] }}mm; left: {{ $layout['qr_left'] }}mm;">
        <img src="{{ $qrDataUri }}" class="qr-img" alt="QR">
        @if(!empty($logos['kemnaker_mark']))
            <div class="abs qr-mark">
                <img src="data:image/png;base64,{{ $logos['kemnaker_mark'] }}" alt="">
            </div>
        @endif
    </div>

    <div class="abs p1-center sign-name" style="top: {{ $layout['sign_name'] }}mm;">{{ $directorName }}</div>
    <div class="abs p1-center sign-title" style="top: {{ $layout['sign_title1'] }}mm;">{{ $directorTitleLine1 }}</div>
    <div class="abs p1-center sign-title" style="top: {{ $layout['sign_title2'] }}mm;">{{ $directorTitleLine2 }}</div>

    <div class="abs footer-meta footer-meta-line" style="top: {{ $layout['meta_number'] }}mm;">
        Certified Number :
    </div>
    <div class="abs footer-meta footer-meta-line" style="top: {{ $layout['meta_value'] }}mm;">
        {{ $certificate->certificate_number }}
    </div>
    <div class="abs footer-meta footer-meta-line" style="top: {{ $layout['meta_issued'] }}mm;">
        Issued Date: {{ $certificate->issued_at->format('Y-m-d') }}
    </div>

</div>

<div class="page page-last">
    <div class="abs p2-wrap">

        @php
            $p2Watermark = $logos['page2_watermark'] ?? $logos['materials_watermark'] ?? $logos['watermark'] ?? null;
        @endphp
        @if(!empty($p2Watermark))
            <img src="data:image/png;base64,{{ $p2Watermark }}" class="abs p2-watermark" style="left: {{ $ref['p2_wm_left'] }}mm; top: {{ $ref['p2_wm_top'] }}mm; width: {{ $ref['p2_wm_w'] }}mm; height: {{ $ref['p2_wm_w'] }}mm;" alt="">
        @endif

        <div class="abs p2-box" style="left: {{ $ref['p2_box_left'] }}mm; top: {{ $ref['p2_box_top'] }}mm; width: {{ $ref['p2_box_w'] }}mm; height: {{ $ref['p2_box_h'] }}mm;">
            <div class="p2-table-wrap">
            <table class="p2-table" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="p2-no">NO</th>
                        <th class="p2-title">MATERI PELATIHAN</th>
                        <th class="p2-code">KODE UNIT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materials as $material)
                        <tr>
                            <td class="p2-no">{{ $loop->iteration }}</td>
                            <td class="p2-title">{{ $material->title }}</td>
                            <td class="p2-code">{{ $material->material_code ?: '-' }}</td>
                        </tr>
                    @endforeach
                    @for($i = max($materialCount, 0) + 1; $i <= $maxMaterialRows; $i++)
                        <tr>
                            <td class="p2-no">{{ $i }}</td>
                            <td class="p2-title">&nbsp;</td>
                            <td class="p2-code">&nbsp;</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            </div>
        </div>

    </div>
</div>

</body>
</html>
