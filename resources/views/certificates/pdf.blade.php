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

    $programLines = $programLines ?? [];
    $hasProgramLine2 = $hasProgramLine2 ?? (isset($programLines[1]) && trim($programLines[1]) !== '');
    $page1Masks = $page1Masks ?? [];
    $page1Layers = $page1Layers ?? [];
    $page2Layers = $page2Layers ?? [];

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
        'p2_box_top'   => 24.16,
        'p2_box_left'  => 10.20,
        'p2_box_w'     => 276.71,
        'p2_box_h'     => 165.02,
        'p2_border'    => 0.794,
        'p2_header_line_y' => 37.66,
        'p2_row_line_ys' => [51.84, 66.03, 80.71, 94.21, 107.71, 121.44, 134.94, 148.68, 162.18, 175.68, 189.18],
        'p2_vline_left'  => 10.60,
        'p2_vline_1'   => 26.40,
        'p2_vline_2'   => 232.15,
        'p2_vline_right' => 286.51,
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

    $maxMaterialRows = 11;
    $materialCount = $materials->count();
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
    font-family: montserrat, 'DejaVu Sans', sans-serif;
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

.p1-layer {
    z-index: 5;
    display: block;
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
.p2-frame {
    position: absolute;
    z-index: 2;
    overflow: visible;
}
.p2-line {
    position: absolute;
    z-index: 2;
    background: #111111;
}
.p2-line--h {
    height: 0.794mm;
}
.p2-line--v {
    width: 0.794mm;
}
.p2-layer {
    z-index: 3;
    display: block;
}
</style>
</head>
<body>

<div class="page">

    @if(!empty($logos['page1_reference_bg']))
        <img src="data:image/png;base64,{{ $logos['page1_reference_bg'] }}" class="abs p1-bg" alt="">
    @endif

    @foreach($page1Masks as $mask)
        <div class="abs field-mask" style="left: {{ $mask['l'] }}mm; top: {{ $mask['t'] }}mm; width: {{ $mask['w'] }}mm; height: {{ $mask['h'] }}mm;"></div>
    @endforeach

    @foreach($page1Layers as $layer)
        <img src="data:image/png;base64,{{ $layer['base64'] }}" class="abs p1-layer" style="top: {{ $layer['top'] }}mm; left: {{ $layer['left'] }}mm; width: {{ $layer['width'] }}mm;" alt="">
    @endforeach

    <div class="abs qr-wrap">
        <img src="{{ $qrDataUri }}" class="qr-img" alt="QR">
    </div>

</div>

<div class="page page-last">
    <div class="abs p2-wrap">

        @php
            $p2Watermark = $logos['page2_watermark'] ?? $logos['blkk_mark'] ?? null;
            $p2Border = $ref['p2_border'];
            $p2Top = $ref['p2_box_top'];
            $p2Left = $ref['p2_box_left'];
            $p2W = $ref['p2_box_w'];
            $p2H = $ref['p2_box_h'];
            $p2Bottom = $p2Top + $p2H;
        @endphp
        @if(!empty($p2Watermark))
            <img src="data:image/png;base64,{{ $p2Watermark }}" class="abs p2-watermark" style="left: {{ $ref['p2_wm_left'] }}mm; top: {{ $ref['p2_wm_top'] }}mm; width: {{ $ref['p2_wm_w'] }}mm; height: {{ $ref['p2_wm_w'] }}mm;" alt="">
        @endif

        <div class="abs p2-frame" style="left: 0; top: 0; width: 297mm; height: 210mm;">
            <div class="p2-line p2-line--h" style="left: {{ $p2Left }}mm; top: {{ $p2Top }}mm; width: {{ $p2W }}mm;"></div>
            <div class="p2-line p2-line--h" style="left: {{ $p2Left }}mm; top: {{ $ref['p2_header_line_y'] }}mm; width: {{ $p2W }}mm;"></div>
            @foreach($ref['p2_row_line_ys'] as $rowLineY)
                <div class="p2-line p2-line--h" style="left: {{ $p2Left }}mm; top: {{ $rowLineY }}mm; width: {{ $p2W }}mm;"></div>
            @endforeach

            <div class="p2-line p2-line--v" style="left: {{ $ref['p2_vline_left'] }}mm; top: {{ $p2Top }}mm; height: {{ $p2H }}mm;"></div>
            <div class="p2-line p2-line--v" style="left: {{ $ref['p2_vline_1'] }}mm; top: {{ $p2Top }}mm; height: {{ $p2H }}mm;"></div>
            <div class="p2-line p2-line--v" style="left: {{ $ref['p2_vline_2'] }}mm; top: {{ $p2Top }}mm; height: {{ $p2H }}mm;"></div>
            <div class="p2-line p2-line--v" style="left: {{ $ref['p2_vline_right'] - $p2Border }}mm; top: {{ $p2Top }}mm; height: {{ $p2H }}mm;"></div>

            @foreach($page2Layers as $layer)
                <img src="data:image/png;base64,{{ $layer['base64'] }}" class="abs p2-layer" style="top: {{ $layer['top'] }}mm; left: {{ $layer['left'] }}mm; width: {{ $layer['width'] }}mm;" alt="">
            @endforeach
        </div>

    </div>
</div>

</body>
</html>
