@extends('admin.reports.pdf.layout')

@section('content')
<table>
    <thead>
        <tr>
            <th>No</th>
            @foreach(\App\Support\ReportUserFields::headings() as $heading)
                <th>{{ $heading }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                @foreach(\App\Support\ReportUserFields::row($user) as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
