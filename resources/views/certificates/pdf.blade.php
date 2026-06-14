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
    $programFull = 'Telah Berpartisipasi Pada Pelatihan ' . $program->name . ' Tahun ' . $trainingYear;
    $programLines = [$programFull];
    if (mb_strlen($programFull) > 58) {
        $breakAt = (int) (mb_strlen($programFull) * 0.48);
        $spacePos = mb_strrpos(mb_substr($programFull, 0, $breakAt + 14), ' ');
        if ($spacePos !== false && $spacePos > 24) {
            $programLines = [
                trim(mb_substr($programFull, 0, $spacePos)),
                trim(mb_substr($programFull, $spacePos)),
            ];
        }
    }

    $orgParts = preg_split('/\s-\s/', $organization, 2);
    $hasOrgLine2 = is_array($orgParts) && count($orgParts) === 2;
    $orgHtml = $hasOrgLine2
        ? e(trim($orgParts[0])) . ' -<br>' . e(trim($orgParts[1]))
        : e($organization);

    $hasProgramLine2 = isset($programLines[1]);
    $bodyShift = ($hasOrgLine2 ? 4.2 : 0) + ($hasProgramLine2 ? 6.8 : 0);
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

/* PAGE 1 — SIDEBAR */
.p1-sidebar {
    left: 0;
    top: 0;
    width: 52mm;
    height: 210mm;
    background-color: #1a3260;
    background-repeat: no-repeat;
    background-size: 52mm 210mm;
    background-position: top left;
    z-index: 1;
}

/* PAGE 1 — LOGO BAR */
.p1-logo {
    top: 4mm;
    height: 17mm;
    text-align: center;
    line-height: 17mm;
}
.p1-logo img,
.p1-logo .logo-indonesia-text {
    display: inline-block;
    vertical-align: middle;
    line-height: normal;
}
.p1-logo-1 { left: 52mm;  width: 40.8mm; }
.p1-logo-2 { left: 92.8mm; width: 40.8mm; }
.p1-logo-3 { left: 133.6mm; width: 40.8mm; }
.p1-logo-4 { left: 174.4mm; width: 40.8mm; }
.p1-logo-5 { left: 215.2mm; width: 40.8mm; }
.p1-logo-6 { left: 256mm; width: 31mm; }

.logo-indonesia-text {
    font-size: 10.1pt;
    font-weight: bold;
    color: #111827;
    line-height: 1.05;
    text-align: center;
    padding-top: 2.5mm;
}

.p1-divider {
    left: 52mm;
    top: 27.5mm;
    width: 235mm;
    height: 0;
    border: none;
    border-top: 0.5px solid #b8c4d4;
}

/* PAGE 1 — BODY (above sidebar) */
.p1-text,
.footer-meta {
    z-index: 5;
}

.p1-text {
    left: 52mm;
    width: 235mm;
    text-align: center;
}

.txt-intro-id {
    top: 32.9mm;
    font-size: 10.5pt;
    font-weight: bold;
    color: #111827;
    letter-spacing: 0.2px;
}
.txt-intro-en {
    top: 39.2mm;
    font-size: 8.5pt;
    font-style: italic;
    color: #6b7280;
}
.txt-name {
    top: 47.9mm;
    font-size: 25pt;
    font-weight: bold;
    color: #111827;
    letter-spacing: 0.4px;
    text-transform: uppercase;
    line-height: 1.05;
}
.txt-org {
    top: 61.8mm;
    font-size: 10.5pt;
    font-weight: bold;
    color: #111827;
    line-height: 1.5;
    padding: 0 4mm;
}
.txt-program {
    top: {{ number_format(79.5 + ($hasOrgLine2 ? 4.2 : 0), 1, '.', '') }}mm;
    font-size: 10.5pt;
    font-weight: bold;
    color: #111827;
    line-height: 1.45;
    padding: 0 4mm;
}
.txt-program-2 {
    top: {{ number_format(86.9 + ($hasOrgLine2 ? 4.2 : 0), 1, '.', '') }}mm;
    font-size: 10.5pt;
    font-weight: bold;
    color: #111827;
    line-height: 1.45;
    padding: 0 4mm;
}
.txt-en {
    font-size: 8.5pt;
    font-style: italic;
    color: #6b7280;
    line-height: 1.35;
}
.txt-en-org { top: {{ number_format(92.5 + $bodyShift, 1, '.', '') }}mm; }
.txt-non-akademik {
    top: {{ number_format(99.6 + $bodyShift, 1, '.', '') }}mm;
    font-size: 10.5pt;
    font-weight: bold;
    color: #111827;
}
.txt-en-degree { top: {{ number_format(107.3 + $bodyShift, 1, '.', '') }}mm; }
.txt-degree {
    top: {{ number_format(118.8 + $bodyShift, 1, '.', '') }}mm;
    font-size: 17pt;
    font-weight: bold;
    color: #dc2626;
    letter-spacing: 0.2px;
}
.txt-validity {
    top: {{ number_format(131.0 + $bodyShift, 1, '.', '') }}mm;
    font-size: 10.5pt;
    color: #111827;
    font-weight: bold;
}
.txt-validity-en {
    top: {{ number_format(138.8 + $bodyShift, 1, '.', '') }}mm;
    font-size: 8.5pt;
    font-style: italic;
    color: #6b7280;
}

/* PAGE 1 — FOOTER (stacked center block) */
.p1-footer {
    left: 52mm;
    width: 235mm;
    top: {{ number_format(150.5 + min($bodyShift, 8), 1, '.', '') }}mm;
    text-align: center;
    z-index: 5;
}

.lbl-verify {
    font-size: 10.5pt;
    font-weight: bold;
    color: #111827;
    line-height: 1.2;
    margin-bottom: 2mm;
}

.qr-wrap {
    width: 24mm;
    height: 24mm;
    margin: 0 auto;
    position: relative;
}
.qr-img {
    width: 24mm;
    height: 24mm;
    display: block;
}
.qr-center {
    position: absolute;
    top: 8.5mm;
    left: 8.5mm;
    width: 7mm;
    height: 7mm;
    background: #ffffff;
    border-radius: 50%;
    padding: 0.6mm;
}
.qr-center img {
    width: 5.8mm;
    height: 5.8mm;
    display: block;
}

.sign-name {
    margin-top: 3.5mm;
    font-size: 12.5pt;
    font-weight: bold;
    color: #111827;
    line-height: 1.25;
}
.sign-title-1 {
    margin-top: 1.2mm;
    font-size: 12.5pt;
    font-weight: normal;
    color: #111827;
    line-height: 1.3;
}
.sign-title-2 {
    margin-top: 0.5mm;
    font-size: 12.5pt;
    font-weight: normal;
    color: #111827;
    line-height: 1.3;
}

.footer-meta {
    right: 7mm;
    top: 185.5mm;
    text-align: right;
    font-size: 10.5pt;
    font-weight: bold;
    color: #1a4374;
    line-height: 1.72;
    z-index: 5;
}

/* PAGE 2 — MATERI */
.p2-wrap {
    left: 0;
    top: 0;
    width: 297mm;
    height: 210mm;
}
.p2-watermark {
    left: 101mm;
    top: 63mm;
    width: 95mm;
    opacity: 0.10;
    z-index: 0;
}
.p2-box {
    left: 10mm;
    top: 8mm;
    width: 277mm;
    height: 194mm;
    border: 2px solid #111111;
    overflow: hidden;
    z-index: 1;
}
.p2-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    font-size: 9pt;
}
.p2-table th,
.p2-table td {
    border: 1px solid #111111;
    vertical-align: middle;
    padding: 1.5mm 2.5mm;
}
.p2-table th {
    font-weight: bold;
    text-align: center;
    font-size: 9pt;
    height: 12.5mm;
    background: #ffffff;
    letter-spacing: 0.3px;
    border-bottom-width: 1.5px;
}
.p2-table td { height: 13.6mm; }
.p2-no  { width: 14mm; text-align: center; }
.p2-title { text-align: left; padding-left: 3mm; }
.p2-code { width: 52mm; text-align: center; font-size: 8.5pt; }
.p2-empty { text-align: center; font-style: italic; color: #6b7280; }
</style>
</head>
<body>

<div class="page">

    <div class="abs p1-sidebar" @if(!empty($logos['sidebar_bg'])) style="background-image: url('data:image/png;base64,{{ $logos['sidebar_bg'] }}');" @endif></div>

    <div class="abs p1-logo p1-logo-1">
        @if(!empty($logos['kemnaker']))
            <img src="data:image/png;base64,{{ $logos['kemnaker'] }}" style="height:13mm;width:auto;" alt="">
        @endif
    </div>
    <div class="abs p1-logo p1-logo-2">
        @if(!empty($logos['ymt']))
            <img src="data:image/png;base64,{{ $logos['ymt'] }}" style="height:12mm;width:auto;" alt="">
        @endif
    </div>
    <div class="abs p1-logo p1-logo-3">
        @if(!empty($logos['vokasi']))
            <img src="data:image/png;base64,{{ $logos['vokasi'] }}" style="height:12mm;width:auto;" alt="">
        @endif
    </div>
    <div class="abs p1-logo p1-logo-4">
        <div class="logo-indonesia-text">Indonesia<br>Skills</div>
    </div>
    <div class="abs p1-logo p1-logo-5">
        @if(!empty($logos['skills_swoosh']))
            <img src="data:image/png;base64,{{ $logos['skills_swoosh'] }}" style="height:11mm;width:auto;" alt="">
        @elseif(!empty($logos['blkk_mark']))
            <img src="data:image/png;base64,{{ $logos['blkk_mark'] }}" style="height:11mm;width:auto;" alt="">
        @elseif(!empty($logos['indonesia_skills']))
            <img src="data:image/png;base64,{{ $logos['indonesia_skills'] }}" style="height:10mm;width:auto;" alt="">
        @endif
    </div>
    <div class="abs p1-logo p1-logo-6">
        @if(!empty($logos['siapkerja']))
            <img src="data:image/png;base64,{{ $logos['siapkerja'] }}" style="height:11mm;width:auto;" alt="">
        @endif
    </div>

    <hr class="abs p1-divider">

    <div class="abs p1-text txt-intro-id">SERTIFIKAT INI MENERANGKAN BAHWA :</div>
    <div class="abs p1-text txt-intro-en">This Certificate explains that :</div>

    <div class="abs p1-text txt-name">{{ strtoupper($participant->name) }}</div>

    <div class="abs p1-text txt-org">
        yang diselenggarakan oleh {!! $orgHtml !!}
    </div>

    <div class="abs p1-text txt-program">{{ $programLines[0] }}</div>
    @if(isset($programLines[1]))
        <div class="abs p1-text txt-program-2">{{ $programLines[1] }}</div>
    @endif

    <div class="abs p1-text txt-en txt-en-org">Organized by {{ $organizationEn }}</div>

    <div class="abs p1-text txt-non-akademik">Serta berhak atas Gelar Non-Akademik</div>
    <div class="abs p1-text txt-en txt-en-degree">As well as the rights to Non-Academic Degree</div>

    <div class="abs p1-text txt-degree">{{ $degree }}</div>

    <div class="abs p1-text txt-validity">
        Sertifikat ini berlaku untuk : {{ $validityYears }} ({{ $validityWordId }}) Tahun
    </div>
    <div class="abs p1-text txt-validity-en">
        This Certificate is valid for {{ $validityYears }} ({{ $validityWordEn }}) years
    </div>

    <div class="abs p1-footer">
        <div class="lbl-verify">Diverifikasi Oleh :</div>
        <div class="qr-wrap">
            <img src="{{ $qrDataUri }}" class="qr-img" alt="QR">
            @if(!empty($logos['kemnaker_mark']))
                <div class="qr-center">
                    <img src="data:image/png;base64,{{ $logos['kemnaker_mark'] }}" alt="">
                </div>
            @endif
        </div>
        <div class="sign-name">{{ $directorName }}</div>
        <div class="sign-title-1">{{ $directorTitleLine1 }}</div>
        <div class="sign-title-2">{{ $directorTitleLine2 }}</div>
    </div>

    <div class="abs footer-meta">
        Certified Number :<br>
        {{ $certificate->certificate_number }}<br>
        Issued Date: {{ $certificate->issued_at->format('Y-m-d') }}
    </div>

</div>

<div class="page page-last">
    <div class="abs p2-wrap">

        @if(!empty($logos['page2_watermark']))
            <img src="data:image/png;base64,{{ $logos['page2_watermark'] }}" class="abs p2-watermark" alt="">
        @elseif(!empty($logos['materials_watermark']))
            <img src="data:image/png;base64,{{ $logos['materials_watermark'] }}" class="abs p2-watermark" alt="">
        @elseif(!empty($logos['watermark']))
            <img src="data:image/png;base64,{{ $logos['watermark'] }}" class="abs p2-watermark" alt="">
        @endif

        <div class="abs p2-box">
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

</body>
</html>
