@extends('admin.reports.pdf.layout')

@section('content')
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            @foreach($meetings as $meeting)
                <th>P{{ $meeting->meeting_number }}</th>
            @endforeach
            <th>Hadir</th>
            <th>Izin</th>
            <th>Sakit</th>
            <th>Alpha</th>
        </tr>
    </thead>
    <tbody>
        @foreach(array_values($attendanceMatrix) as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row['participant']->name }}</td>
                @foreach($meetings as $meeting)
                    <td>{{ $row['attendances'][$meeting->meeting_number] ?? '-' }}</td>
                @endforeach
                <td>{{ $row['present_count'] ?? 0 }}</td>
                <td>{{ $row['permission_count'] ?? 0 }}</td>
                <td>{{ $row['sick_count'] ?? 0 }}</td>
                <td>{{ $row['absent_count'] ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
