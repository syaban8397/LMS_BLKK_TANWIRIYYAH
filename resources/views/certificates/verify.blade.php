<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sertifikat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 max-w-lg w-full p-8">
        <div class="text-center mb-6">
            <div class="text-4xl mb-2">✅</div>
            <h1 class="text-xl font-bold text-slate-800">Sertifikat Valid</h1>
            <p class="text-sm text-slate-500 mt-1">Sertifikat ini terdaftar di LMS BLKK Tanwiriyyah</p>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">Nama</span>
                <span class="font-semibold text-slate-800">{{ $certificate->participant->name }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">Program</span>
                <span class="font-medium text-slate-800 text-right">{{ $certificate->class->program->name }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">Kelas</span>
                <span class="font-medium text-slate-800">{{ $certificate->class->title }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">Nomor Sertifikat</span>
                <span class="font-mono text-xs text-slate-700">{{ $certificate->certificate_number }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Tanggal Terbit</span>
                <span class="font-medium text-slate-800">{{ $certificate->issued_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>
</body>
</html>