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
        $programLines = [
            'Telah Berpartisipasi Pada Pelatihan ' . $programName,
            'Tahun ' . $trainingYear,
        ];
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

    // Koordinat mm diekstrak dari RAIHAN TAUVIQUL HADY IFDAL.pdf (PyMuPDF, analyze_ref_pdf.py)
    $ref = [
        'sidebar_w'    => 63.0,
        'content_l'    => 63.0,
        'content_w'    => 234.0,
        'divider_top'  => 30.0,
        'intro_id'     => 32.9,
        'intro_en'     => 39.2,
        'name'         => 47.9,
        'org_line1'    => 61.8,
        'org_line2'    => 69.2,
        'program'      => 79.6,
        'program_2'    => 87.0,
        'en_org'       => 95.9,
        'non_akademik' => 103.0,
        'en_degree'    => 110.8,
        'degree'       => 122.3,
        'validity'     => 134.5,
        'validity_en'  => 142.3,
        'verify'       => 154.3,
        'qr_top'       => 164.4,
        'qr_size'      => 20.7,
        'qr_left'      => 171.65,
        'sign_name'    => 187.0,
        'sign_title1'  => 193.6,
        'sign_title2'  => 199.8,
        'meta_number'  => 187.0,
        'meta_value'   => 191.8,
        'meta_issued'  => 196.5,
        'p2_box_top'   => 24.2,
        'p2_box_left'  => 10.6,
        'p2_box_w'     => 276.3,
        'p2_box_h'     => 165.0,
        'p2_header_h'  => 13.8,
        'p2_row_h'     => 13.75,
        'p2_col_no'    => 14.0,
        'p2_col_code'  => 46.0,
        'p2_col_no_pt' => 40,
        'p2_col_code_pt' => 130,
        'p2_col_title_pt' => 613,
        'p2_table_w_pt' => 783,
        'p2_wm_left'   => 64.0,
        'p2_wm_top'    => 20.5,
        'p2_wm_w'      => 169.1,
        'logo_1' => ['l' => 72.9, 't' => 12.2, 'w' => 43.9, 'h' => 17.7, 'img_h' => 13],
        'logo_2' => ['l' => 120.1, 't' => 11.0, 'w' => 46.3, 'h' => 17.5, 'img_h' => 11],
        'logo_3' => ['l' => 171.6, 't' => 15.1, 'w' => 31.5, 'h' => 10.1, 'img_h' => 10],
        'logo_4' => ['l' => 206.2, 't' => 15.9, 'w' => 20.0, 'h' => 10.0, 'img_h' => 10],
        'logo_5' => ['l' => 227.5, 't' => 9.7, 'w' => 15.4, 'h' => 16.1, 'img_h' => 11],
        'logo_6' => ['l' => 242.9, 't' => 10.7, 'w' => 33.6, 'h' => 18.8, 'img_h' => 11],
        'box' => [
            'intro_id'     => ['l' => 124.5],
            'intro_en'     => ['l' => 140.2],
            'name'         => ['l' => 106.2, 'w' => 152.0, 'align' => 'center'],
            'org_line1'    => ['l' => 89.3],
            'org_line2'    => ['l' => 134.6],
            'program'      => ['l' => 83.5],
            'program_2'    => ['l' => 125.5],
            'en_org'       => ['l' => 116.3],
            'non_akademik' => ['l' => 133.1],
            'en_degree'    => ['l' => 131.6],
            'degree'       => ['l' => 121.6],
            'validity'     => ['l' => 125.4],
            'validity_en'  => ['l' => 135.3],
            'verify'       => ['l' => 156.6],
            'sign_name'    => ['l' => 159.0],
            'sign_title1'  => ['l' => 155.3],
            'sign_title2'  => ['l' => 164.8],
            'meta_number'  => ['l' => 246.5],
            'meta_value'   => ['l' => 238.0, 'w' => 49.0],
            'meta_issued'  => ['l' => 241.9, 'w' => 44.5],
        ],
    ];

    $boxStyle = static function (array $box): string {
        if (($box['align'] ?? 'left') === 'center') {
            return sprintf('left: %smm; width: %smm; text-align: center;', $box['l'], $box['w']);
        }

        $width = isset($box['w'])
            ? sprintf('width: %smm;', $box['w'])
            : '';

        return sprintf('left: %smm; %stext-align: left;', $box['l'], $width);
    };

    // Halaman 1: mask putih menutup teks dinamis pada background referensi Raihan
    $p1Masks = [
        'name'        => ['l' => 105.5, 't' => 46.5, 'w' => 156.5, 'h' => 14.5],
        'program'     => ['l' => 82.0, 't' => 78.5, 'w' => 190.5, 'h' => 9.5],
        'program_2'   => ['l' => 124.0, 't' => 86.0, 'w' => 106.5, 'h' => 9.5],
        'degree'      => ['l' => 120.0, 't' => 120.5, 'w' => 130.0, 'h' => 12.5],
        'validity'    => ['l' => 124.0, 't' => 133.5, 'w' => 122.0, 'h' => 9.5],
        'validity_en' => ['l' => 134.0, 't' => 141.3, 'w' => 102.0, 'h' => 9.5],
        'meta_value'  => ['l' => 237.5, 't' => 190.8, 'w' => 50.0, 'h' => 6.5],
        'meta_issued' => ['l' => 241.0, 't' => 195.5, 'w' => 46.0, 'h' => 6.5],
        'qr'          => ['l' => 171.0, 't' => 163.8, 'w' => 22.0, 'h' => 22.0],
    ];

    $p1DynamicOffset = -2.5;
    $fonts = $fonts ?? [];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sertifikat - {{ $participant->name }}</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

@if(!empty($fonts['regular']))
@font-face {
    font-family: 'Montserrat';
    font-style: normal;
    font-weight: 400;
    src: url('data:font/truetype;charset=utf-8;base64,{{ $fonts['regular'] }}') format('truetype');
}
@endif
@if(!empty($fonts['bold']))
@font-face {
    font-family: 'Montserrat';
    font-style: normal;
    font-weight: 700;
    src: url('data:font/truetype;charset=utf-8;base64,{{ $fonts['bold'] }}') format('truetype');
}
@endif
@if(!empty($fonts['black']))
@font-face {
    font-family: 'Montserrat';
    font-style: normal;
    font-weight: 900;
    src: url('data:font/truetype;charset=utf-8;base64,{{ $fonts['black'] }}') format('truetype');
}
@endif
@if(!empty($fonts['italic']))
@font-face {
    font-family: 'Montserrat';
    font-style: italic;
    font-weight: 400;
    src: url('data:font/truetype;charset=utf-8;base64,{{ $fonts['italic'] }}') format('truetype');
}
@endif
@if(!empty($fonts['bold_italic']))
@font-face {
    font-family: 'Montserrat';
    font-style: italic;
    font-weight: 700;
    src: url('data:font/truetype;charset=utf-8;base64,{{ $fonts['bold_italic'] }}') format('truetype');
}
@endif

@page {
    size: 297mm 210mm;
    margin: 0;
}

body {
    font-family: 'Montserrat', 'DejaVu Sans', Arial, sans-serif;
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

/* PAGE 1 — background referensi + overlay dinamis */
.p1-bg {
    left: 0;
    top: 0;
    width: 297mm;
    height: 210mm;
    z-index: 0;
}

.field-mask {
    background: #ffffff;
    z-index: 2;
}

.p1-dynamic {
    z-index: 5;
    font-family: 'Montserrat', 'DejaVu Sans', Arial, sans-serif;
}

.p1-name {
    font-size: 25pt;
    font-weight: 900;
    color: #000000;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    line-height: 1.05;
    white-space: nowrap;
}

.p1-program {
    font-size: 15pt;
    font-weight: 700;
    color: #002d5b;
    line-height: 1.45;
    white-space: nowrap;
}

.p1-degree {
    font-size: 17pt;
    font-weight: 900;
    color: #d32f2f;
    letter-spacing: 0.3px;
    line-height: 1.15;
    white-space: nowrap;
}

.p1-validity {
    font-size: 15pt;
    font-weight: 700;
    color: #002d5b;
    white-space: nowrap;
}

.p1-validity-en {
    font-size: 13pt;
    font-weight: 700;
    font-style: italic;
    color: #757575;
    white-space: nowrap;
}

.p1-meta {
    font-size: 10pt;
    font-weight: 700;
    color: #002d5b;
    white-space: nowrap;
    word-break: keep-all;
    overflow-wrap: normal;
    hyphens: manual;
    line-height: 1.1;
}

.qr-wrap {
    z-index: 6;
    top: {{ $ref['qr_top'] }}mm;
    left: {{ $ref['qr_left'] }}mm;
}
.qr-img {
    width: {{ $ref['qr_size'] }}mm;
    height: {{ $ref['qr_size'] }}mm;
    display: block;
}

/* PAGE 2 — MATERI (koordinat dari RAIHAN TAUVIQUL HADY IFDAL.pdf hal. 2) */
.p2-wrap {
    left: 0;
    top: 0;
    width: 297mm;
    height: 210mm;
}
.p2-watermark {
    z-index: 0;
}
.p2-table-shell {
    overflow: hidden;
    z-index: 2;
    position: absolute;
    background: transparent;
}
.p2-table {
    width: 100%;
    height: 100%;
    border: 2px solid #111111;
    border-collapse: collapse;
    table-layout: fixed;
}
.p2-table th,
.p2-table td {
    border: 1px solid #111111;
    vertical-align: middle;
    padding: 0 1.5mm;
}
.p2-table th {
    font-weight: bold;
    text-align: center;
    font-size: 13pt;
    height: {{ $ref['p2_header_h'] }}mm;
    background: transparent;
    letter-spacing: 0.3px;
    border-bottom: 1.5px solid #111111;
    line-height: 1;
    white-space: nowrap;
    padding: 0;
}
.p2-table th.p2-code-head {
    font-size: 11pt;
}
.p2-table td {
    height: {{ $ref['p2_row_h'] }}mm;
    background: transparent;
    line-height: 1.1;
    overflow: hidden;
}
.p2-no {
    width: 5%;
    text-align: center;
    font-size: 13pt;
    white-space: nowrap;
    padding: 0;
}
.p2-title {
    width: 78%;
    text-align: left;
    padding-left: 5mm;
    padding-right: 1.5mm;
    font-size: 12pt;
    white-space: nowrap;
    overflow: hidden;
}
.p2-code {
    width: 17%;
    text-align: center;
    font-size: 13pt;
    white-space: nowrap;
    padding: 0;
}
.p2-code-head {
    font-size: 11pt;
}
</style>
</head>
<body>

<div class="page">

    @if(!empty($logos['page1_reference_bg']))
        <img src="data:image/png;base64,{{ $logos['page1_reference_bg'] }}" class="abs p1-bg" alt="">
    @endif

    @foreach($p1Masks as $mask)
        <div class="abs field-mask" style="left: {{ $mask['l'] }}mm; top: {{ $mask['t'] }}mm; width: {{ $mask['w'] }}mm; height: {{ $mask['h'] }}mm;"></div>
    @endforeach

    <div class="abs p1-dynamic p1-name" style="top: {{ $ref['name'] + $p1DynamicOffset }}mm; {{ $boxStyle($ref['box']['name']) }}">{{ strtoupper($participant->name) }}</div>

    <div class="abs p1-dynamic p1-program" style="top: {{ $ref['program'] + $p1DynamicOffset }}mm; {{ $boxStyle($ref['box']['program']) }}">{{ $programLines[0] }}</div>
    @if($hasProgramLine2)
        <div class="abs p1-dynamic p1-program" style="top: {{ $ref['program_2'] + $p1DynamicOffset }}mm; {{ $boxStyle($ref['box']['program_2']) }}">{{ $programLines[1] }}</div>
    @endif

    <div class="abs p1-dynamic p1-degree" style="top: {{ $ref['degree'] + $p1DynamicOffset }}mm; {{ $boxStyle(['l' => 121.6, 'w' => 126.2, 'align' => 'center']) }}">{{ $degree }}</div>

    <div class="abs p1-dynamic p1-validity" style="top: {{ $ref['validity'] + $p1DynamicOffset }}mm; {{ $boxStyle($ref['box']['validity']) }}">
        Sertifikat ini berlaku untuk : {{ $validityYears }} ({{ $validityWordId }}) Tahun
    </div>
    <div class="abs p1-dynamic p1-validity-en" style="top: {{ $ref['validity_en'] + $p1DynamicOffset }}mm; {{ $boxStyle($ref['box']['validity_en']) }}">
        This Certificate is valid for {{ $validityYears }} ({{ $validityWordEn }}) years
    </div>

    <div class="abs p1-dynamic p1-meta" style="top: {{ $ref['meta_value'] + $p1DynamicOffset }}mm; {{ $boxStyle($ref['box']['meta_value']) }}"><span style="white-space: nowrap;">{{ $certificate->certificate_number }}</span></div>
    <div class="abs p1-dynamic p1-meta" style="top: {{ $ref['meta_issued'] + $p1DynamicOffset }}mm; {{ $boxStyle($ref['box']['meta_issued']) }}"><span style="white-space: nowrap;">Issued Date: {{ $certificate->issued_at->format('Y-m-d') }}</span></div>

    <div class="abs qr-wrap">
        <img src="{{ $qrDataUri }}" class="qr-img" alt="QR">
    </div>

</div>

<div class="page page-last">
    <div class="abs p2-wrap">

        @php
            $p2Watermark = $logos['page2_watermark'] ?? $logos['blkk_mark'] ?? null;
            $p2TableOffset = 1.1;
            $p2Top = $ref['p2_box_top'] - $p2TableOffset;
            $p2WmTop = $ref['p2_wm_top'];
            $p2ColTitle = $ref['p2_box_w'] - $ref['p2_col_no'] - $ref['p2_col_code'];
        @endphp
        @if(!empty($p2Watermark))
            <img src="data:image/png;base64,{{ $p2Watermark }}" class="abs p2-watermark" style="left: {{ $ref['p2_wm_left'] }}mm; top: {{ $p2WmTop }}mm; width: {{ $ref['p2_wm_w'] }}mm; height: {{ $ref['p2_wm_w'] }}mm;" alt="">
        @endif

        <div class="abs p2-table-shell" style="left: {{ $ref['p2_box_left'] }}mm; top: {{ $p2Top }}mm; width: {{ $ref['p2_box_w'] }}mm; height: {{ $ref['p2_box_h'] }}mm;">
            <table class="p2-table" width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="p2-no" width="5%">NO</th>
                        <th class="p2-title" width="78%">MATERI PELATIHAN</th>
                        <th class="p2-code p2-code-head" width="17%">KODE UNIT</th>
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

</body>
</html>
