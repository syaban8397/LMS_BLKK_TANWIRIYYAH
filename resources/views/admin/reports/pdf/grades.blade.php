@extends('admin.reports.pdf.layout')

@section('content')
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Kelas</th>
            <th>Program</th>
            <th>Nilai Tugas</th>
            <th>Nilai Absensi</th>
            <th>Nilai Akhir</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $index => $grade)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $grade->participant->name ?? '-' }}</td>
                <td>{{ $grade->participant->email ?? '-' }}</td>
                <td>{{ $grade->class->title ?? '-' }}</td>
                <td>{{ $grade->class->program->name ?? '-' }}</td>
                <td>{{ $grade->assignment_score ?? '-' }}</td>
                <td>{{ $grade->attendance_score ?? '-' }}</td>
                <td>{{ $grade->final_score ?? '-' }}</td>
                <td>{{ $grade->status ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
