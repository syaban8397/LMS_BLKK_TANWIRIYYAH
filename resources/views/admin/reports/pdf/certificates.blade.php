@extends('admin.reports.pdf.layout')

@section('content')
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Sertifikat</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Kelas</th>
            <th>Program</th>
            <th>Nilai Akhir</th>
            <th>Kehadiran</th>
            <th>Terbit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $index => $certificate)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $certificate->certificate_number }}</td>
                <td>{{ $certificate->participant->name ?? '-' }}</td>
                <td>{{ $certificate->participant->email ?? '-' }}</td>
                <td>{{ $certificate->class->title ?? '-' }}</td>
                <td>{{ $certificate->class->program->name ?? '-' }}</td>
                <td>{{ $certificate->final_score ?? '-' }}</td>
                <td>{{ $certificate->attendance_percentage ?? '-' }}%</td>
                <td>{{ optional($certificate->issued_at)->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
