@extends('admin.reports.pdf.layout')

@section('content')
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Kelas</th>
            <th>Program</th>
            <th>Instruktur</th>
            <th>Status</th>
            <th>Peserta</th>
            <th>Materi</th>
            <th>Tugas</th>
            <th>Mulai</th>
            <th>Selesai</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $index => $class)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $class->code }}</td>
                <td>{{ $class->title }}</td>
                <td>{{ $class->program->name ?? '-' }}</td>
                <td>{{ $class->instructor->name ?? '-' }}</td>
                <td>{{ $class->status }}</td>
                <td>{{ $class->participants_count ?? 0 }}</td>
                <td>{{ $class->materials_count ?? 0 }}</td>
                <td>{{ $class->assignments_count ?? 0 }}</td>
                <td>{{ optional($class->start_date)->format('Y-m-d') }}</td>
                <td>{{ optional($class->end_date)->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
