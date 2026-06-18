@if(session('success'))
    <x-lms-flash type="success" role="status">{{ session('success') }}</x-lms-flash>
@endif

@if(session('error'))
    <x-lms-flash type="error" role="alert">{{ session('error') }}</x-lms-flash>
@endif

@if(session('info'))
    <x-lms-flash type="info" role="status">{{ session('info') }}</x-lms-flash>
@endif

@if(session('warning'))
    <x-lms-flash type="warning" role="alert">{{ session('warning') }}</x-lms-flash>
@endif
