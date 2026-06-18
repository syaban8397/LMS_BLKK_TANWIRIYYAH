@php use App\Support\ReportUserFields; @endphp
@foreach(ReportUserFields::displayRow($user) as $value)
    <td class="px-3 py-3 text-slate-600 whitespace-nowrap">{{ $value !== '' ? $value : '-' }}</td>
@endforeach
