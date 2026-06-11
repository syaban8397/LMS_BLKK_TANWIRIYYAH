<x-app-layout>
    <div class="space-y-5">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Create New Class</h1>
                <p class="text-sm text-slate-500 mt-0.5">Add a new class to the LMS BLKK Tanwiriyyah system.</p>
            </div>
            <div class="hidden md:flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs shadow-sm">
                🏫 Class Management
            </div>
        </div>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg p-3 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="dashboard-card bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <form action="{{ route('admin.classes.store') }}" method="POST">
                @csrf

                @include('admin.classes.form')

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.classes.index') }}" 
                       class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow-sm hover:shadow-md">
                        Save Class
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .dashboard-card {
            transition: all 0.2s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.08);
        }
    </style>
</x-app-layout>