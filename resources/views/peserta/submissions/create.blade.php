<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div><h2 class="text-2xl font-bold">Submit Assignment</h2><p>{{ $assignment->title }} - {{ $class->title }}</p></div>
            <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="px-4 py-2 bg-slate-200 rounded-xl">Back</a>
        </div>
    </x-slot>
    <div class="max-w-3xl mx-auto px-4 py-6">
        <div class="bg-white rounded-3xl shadow p-8">
            <form action="{{ route('peserta.submissions.store', [$class, $assignment]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div><label class="font-semibold">📎 Upload File</label><input type="file" name="file" class="w-full border rounded-2xl p-3">@error('file')<p class="text-red-500">{{ $message }}</p>@enderror<p class="text-xs text-slate-500">Max 20MB</p></div>
                    <div><label class="font-semibold">🔗 URL (Google Drive, GitHub, etc.)</label><input type="url" name="url" class="w-full border rounded-2xl p-3">@error('url')<p class="text-red-500">{{ $message }}</p>@enderror</div>
                    <div><label class="font-semibold">📝 Notes</label><textarea name="notes" rows="4" class="w-full border rounded-2xl p-3"></textarea></div>
                    <div class="bg-yellow-50 p-4 rounded-2xl"><p>⚠️ Deadline: {{ $assignment->deadline->format('d M Y H:i') }}</p></div>
                </div>
                <div class="border-t mt-8 pt-6 flex justify-end gap-3">
                    <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="px-6 py-3 bg-slate-100 rounded-2xl">Cancel</a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-2xl">Submit</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>