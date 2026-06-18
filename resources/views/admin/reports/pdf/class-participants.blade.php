@extends('admin.reports.pdf.layout')

@section('content')
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Nilai Akhir</th>
            <th>Absensi</th>
            <th>Status</th>
            <th>Sertifikat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row['participant']->name }}</td>
                <td>{{ $row['participant']->email }}</td>
                <td>{{ $row['final_grade']?->final_score ?? '-' }}</td>
                <td>{{ $row['attendance_percentage'] ?? 0 }}%</td>
                <td>{{ $row['final_grade']?->status ?? '-' }}</td>
                <td>{{ $row['certificate']?->certificate_number ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
