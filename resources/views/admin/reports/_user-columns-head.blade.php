@php use App\Support\ReportUserFields; @endphp
@foreach(ReportUserFields::displayHeadings() as $heading)
    <th class="px-3 py-3 text-left whitespace-nowrap">{{ $heading }}</th>
@endforeach
