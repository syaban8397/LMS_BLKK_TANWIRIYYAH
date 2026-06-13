@php
    $validityWordId = match ((int) $validityYears) {
        1 => 'Satu', 2 => 'Dua', 3 => 'Tiga', 4 => 'Empat', 5 => 'Lima',
        default => (string) $validityYears,
    };
    $validityWordEn = match ((int) $validityYears) {
        1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five',
        default => (string) $validityYears,
    };
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat - {{ $participant->name }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            color: #1a1a1a;
        }

        .page {
            width: 297mm;
            height: 210mm;
            position: relative;
            page-break-after: always;
        }
        .page:last-child {
            page-break-after: auto;
        }

        /* LAYOUT TABLE DENGAN LEBAR PASTI */
        .cert-layout {
            width: 100%;
            height: 210mm;
            border-collapse: collapse;
            table-layout: fixed;
        }
        
        /* SIDEBAR KIRI - LEBAR 53mm (sekitar 18%) */
        .cert-layout td.sidebar-cell {
            width: 53mm;
            vertical-align: top;
            background: #2a3038;
        }
        
        /* KONTEN UTAMA - SISANYA */
        .cert-layout td.content-cell {
            vertical-align: top;
            position: relative;
        }

        .sidebar {
            height: 210mm;
            position: relative;
        }
        .sidebar-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.35;
            background-image:
                linear-gradient(30deg, rgba(255,255,255,0.08) 12%, transparent 12%),
                linear-gradient(150deg, rgba(255,255,255,0.08) 12%, transparent 12%),
                linear-gradient(30deg, transparent 88%, rgba(255,255,255,0.08) 88%),
                linear-gradient(150deg, transparent 88%, rgba(255,255,255,0.08) 88%);
            background-size: 24px 42px;
        }
        .sidebar-text-wrap {
            position: absolute;
            top: 24mm;
            left: 5mm;
            width: 36mm;
            height: 160mm;
        }
        .sidebar-table {
            border-collapse: collapse;
            height: 160mm;
            width: 100%;
        }
        .sidebar-table td {
            vertical-align: middle;
            padding: 0;
        }
        .sidebar-main-cell {
            width: 15mm;
            color: #ffffff;
            font-size: 23pt;
            font-weight: bold;
            letter-spacing: 1.5px;
            text-align: center;
            line-height: 0.92;
        }
        .sidebar-sub-cell {
            width: 11mm;
            color: #d1d5db;
            font-size: 6.5pt;
            text-align: center;
            line-height: 1.15;
            padding-left: 1mm;
        }
        .vchar {
            display: block;
            margin: 1mm 0;
        }

        .main-body {
            padding: 7mm 9mm 7mm 9mm;
            position: relative;
            height: 210mm;
        }
        .body-watermark {
            position: absolute;
            top: 48%;
            left: 50%;
            margin-left: -52mm;
            margin-top: -38mm;
            width: 104mm;
            opacity: 0.055;
            z-index: 0;
        }

        .header-logos {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4mm;
            table-layout: fixed;
        }
        .header-logos td {
            text-align: center;
            vertical-align: middle;
            padding: 0 1mm;
            height: 18mm;
        }
        .header-logo {
            max-height: 15mm;
            max-width: 100%;
            width: auto;
            height: auto;
        }

        .center-block {
            text-align: center;
            line-height: 1.5;
            padding-top: 1mm;
            position: relative;
            z-index: 1;
        }
        .intro-id {
            font-size: 9pt;
            font-weight: bold;
            color: #1a2a40;
            margin-top: 1mm;
        }
        .intro-en {
            font-size: 7.5pt;
            font-style: italic;
            color: #6b7280;
            margin-top: 0.8mm;
        }
        .recipient {
            font-size: 20pt;
            font-weight: bold;
            color: #111827;
            margin: 3.5mm 0 3.5mm 0;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }
        .line-id {
            font-size: 9pt;
            color: #111827;
            margin-top: 2mm;
        }
        .line-id strong {
            font-weight: bold;
        }
        .line-en {
            font-size: 7.5pt;
            font-style: italic;
            color: #6b7280;
            margin-top: 1.2mm;
        }
        .degree {
            font-size: 12.5pt;
            font-weight: bold;
            color: #7f1d1d;
            margin: 3.5mm 0 2.5mm 0;
        }
        .validity-id {
            font-size: 8.5pt;
            color: #111827;
            margin-top: 1.5mm;
        }
        .validity-id strong {
            font-weight: bold;
        }

        .footer-wrap {
            position: absolute;
            left: 9mm;
            right: 9mm;
            bottom: 7mm;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-table td {
            vertical-align: bottom;
        }
        .verify-col {
            width: 58%;
            text-align: center;
        }
        .verify-label {
            font-size: 8.5pt;
            font-weight: bold;
            margin-bottom: 1.5mm;
        }
        .qr-img {
            width: 21mm;
            height: 21mm;
        }
        .sign-name {
            font-size: 9.5pt;
            font-weight: bold;
            margin-top: 1.5mm;
        }
        .sign-title {
            font-size: 7.5pt;
            color: #374151;
            line-height: 1.35;
            margin-top: 0.5mm;
        }
        .meta-col {
            width: 42%;
            text-align: right;
            font-size: 8pt;
            color: #111827;
            line-height: 1.6;
        }

        /* HALAMAN 2 - MATERI */
        .materials-page {
            width: 297mm;
            height: 210mm;
            position: relative;
            padding: 10mm 12mm;
        }
        .materials-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -62mm;
            margin-top: -42mm;
            width: 124mm;
            opacity: 0.075;
            z-index: 0;
        }
        .materials-header {
            text-align: center;
            margin-bottom: 8mm;
            position: relative;
            z-index: 2;
        }
        .materials-header h2 {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 2mm;
        }
        .materials-header p {
            font-size: 9pt;
            color: #4b5563;
        }
        .materials-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            position: relative;
            z-index: 2;
        }
        .materials-table th,
        .materials-table td {
            border: 1px solid #000000;
            padding: 2.2mm 2mm;
            vertical-align: middle;
        }
        .materials-table th {
            font-weight: bold;
            text-align: center;
            font-size: 8.5pt;
            background-color: #f8f8f8;
        }
        .materials-table .col-no {
            width: 10mm;
            text-align: center;
        }
        .materials-table .col-code {
            width: 36mm;
            text-align: center;
            font-size: 7.5pt;
        }
        .materials-table .col-title {
            text-align: left;
            padding-left: 2mm;
        }
        .materials-empty {
            text-align: center;
            font-style: italic;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <!-- HALAMAN 1 -->
    <div class="page">
        <table class="cert-layout" cellpadding="0" cellspacing="0">
            <tr>
                <td class="sidebar-cell">
                    <div class="sidebar">
                        <div class="sidebar-pattern"></div>
                        <div class="sidebar-text-wrap">
                            <table class="sidebar-table">
                                <tr>
                                    <td class="sidebar-main-cell">
                                        @foreach(str_split('SERTIFIKAT') as $char)
                                            <span class="vchar">{{ $char }}</span>
                                        @endforeach
                                    </td>
                                    <td class="sidebar-sub-cell">
                                        @foreach(['CERTIFICATE', 'OF', 'TRAINING'] as $word)
                                            <span class="vchar">{{ $word }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
                <td class="content-cell">
                    <div class="main-body">
                        @if(!empty($logos['watermark']))
                            <img src="data:image/png;base64,{{ $logos['watermark'] }}" class="body-watermark" alt="">
                        @endif

                        <table class="header-logos">
                            <tr>
                                <td style="width:20%;">
                                    @if(!empty($logos['kemnaker']))
                                        <img src="data:image/png;base64,{{ $logos['kemnaker'] }}" class="header-logo" alt="Kemnaker">
                                    @endif
                                </td>
                                <td style="width:20%;">
                                    @if(!empty($logos['ymt']))
                                        <img src="data:image/png;base64,{{ $logos['ymt'] }}" class="header-logo" alt="YMT Creatorbase">
                                    @endif
                                </td>
                                <td style="width:20%;">
                                    @if(!empty($logos['vokasi']))
                                        <img src="data:image/png;base64,{{ $logos['vokasi'] }}" class="header-logo" alt="Pelatihan Vokasi">
                                    @endif
                                </td>
                                <td style="width:20%;">
                                    @if(!empty($logos['indonesia_skills']))
                                        <img src="data:image/png;base64,{{ $logos['indonesia_skills'] }}" class="header-logo" alt="Indonesia Skills">
                                    @endif
                                </td>
                                <td style="width:20%;">
                                    @if(!empty($logos['siapkerja']))
                                        <img src="data:image/png;base64,{{ $logos['siapkerja'] }}" class="header-logo" alt="SIAPkerja">
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <div class="center-block">
                            <div class="intro-id">SERTIFIKAT INI MENERANGKAN BAHWA :</div>
                            <div class="intro-en">This Certificate explains that :</div>

                            <div class="recipient">{{ strtoupper($participant->name) }}</div>

                            <div class="line-id">
                                yang diselenggarakan oleh <strong>{{ $organization }}</strong>
                            </div>
                            <div class="line-id">
                                Telah Berpartisipasi Pada <strong>{{ $program->name }} Tahun {{ $class->end_date->format('Y') }}</strong>
                            </div>

                            <div class="line-en">Organized by {{ $organizationEn }}</div>

                            <div class="line-id" style="margin-top:2.5mm;">
                                Serta berhak atas Gelar Non-Akademik
                            </div>
                            <div class="line-en">As well as the rights to Non-Academic Degree</div>

                            <div class="degree">{{ $degree }}</div>

                            <div class="validity-id">
                                Sertifikat ini berlaku untuk : <strong>{{ $validityYears }} ({{ $validityWordId }}) Tahun</strong>
                            </div>
                            <div class="line-en">This Certificate is valid for {{ $validityYears }} ({{ $validityWordEn }}) years</div>
                        </div>

                        <div class="footer-wrap">
                            <table class="footer-table">
                                <tr>
                                    <td class="verify-col">
                                        <div class="verify-label">Diverifikasi Oleh :</div>
                                        <img src="{{ $qrDataUri }}" class="qr-img" alt="QR">
                                        <div class="sign-name">{{ $directorName }}</div>
                                        <div class="sign-title">{{ $directorTitleLine1 }}</div>
                                        <div class="sign-title">{{ $directorTitleLine2 }}</div>
                                    </td>
                                    <td class="meta-col">
                                        <div><strong>Certified Number :</strong></div>
                                        <div>{{ $certificate->certificate_number }}</div>
                                        <div style="margin-top:1.5mm;"><strong>Issued Date:</strong> {{ $certificate->issued_at->format('Y-m-d') }}</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- HALAMAN 2 -->
    <div class="page">
        <div class="materials-page">
            @if(!empty($logos['materials_watermark']))
                <img src="data:image/png;base64,{{ $logos['materials_watermark'] }}" class="materials-watermark" alt="">
            @endif

            <div class="materials-header">
                <h2>DAFTAR MATERI PELATIHAN</h2>
                <p>Training Material List</p>
            </div>

            <table class="materials-table">
                <thead>
                    <tr>
                        <th class="col-no">NO</th>
                        <th class="col-title">MATERI PELATIHAN</th>
                        <th class="col-code">KODE UNIT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materials as $material)
                        <tr>
                            <td class="col-no">{{ $loop->iteration }}</td>
                            <td class="col-title">{{ $material->title }}</td>
                            <td class="col-code">{{ $material->material_code ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="materials-empty">Belum ada materi pada kelas ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>