<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div><h2 class="text-2xl font-bold">Edit Submission</h2><p>{{ $assignment->title }}</p></div>
            <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="px-4 py-2 bg-slate-200 rounded-xl">Back</a>
        </div>
    </x-slot>
    <div class="max-w-3xl mx-auto px-4 py-6">
        <div class="bg-white rounded-3xl shadow p-8">
            <form action="{{ route('peserta.submissions.update', [$class, $assignment, $submission]) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="space-y-6">
                    <div><label class="font-semibold">📎 Upload New File</label><input type="file" name="file" class="w-full border rounded-2xl p-3">@if($submission->file_path)<p class="text-green-600 text-sm">Current: {{ basename($submission->file_path) }}</p>@endif</div>
                    <div><label class="font-semibold">🔗 URL</label><input type="url" name="url" value="{{ old('url', $submission->url) }}" class="w-full border rounded-2xl p-3"></div>
                    <div><label class="font-semibold">📝 Notes</label><textarea name="notes" rows="4" class="w-full border rounded-2xl p-3">{{ old('notes', $submission->notes) }}</textarea></div>
                </div>
                <div class="border-t mt-8 pt-6 flex justify-end gap-3">
                    <a href="{{ route('peserta.assignments.show', [$class, $assignment]) }}" class="px-6 py-3 bg-slate-100 rounded-2xl">Cancel</a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-2xl">Update</button>
                </div>
            </form>
            <form action="{{ route('peserta.submissions.destroy', [$class, $assignment, $submission]) }}" method="POST" class="mt-4" onsubmit="return confirm('Delete permanently?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-600 text-sm hover:underline">Delete Submission</button>
            </form>
        </div>
    </div>
</x-app-layout>