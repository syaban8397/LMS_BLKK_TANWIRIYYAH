@if ($errors->any())
    <x-lms-flash type="error" role="alert">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-lms-flash>
@endif
