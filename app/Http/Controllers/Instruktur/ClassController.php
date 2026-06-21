<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Concerns\AuthorizesInstructorClass;
use App\Http\Controllers\Concerns\EnsuresNestedResourceBelongsToClass;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassParticipant;
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    use AuthorizesInstructorClass;
    use EnsuresNestedResourceBelongsToClass;

    public function index()
    {
        $classes = ClassModel::where('instructor_id', auth()->id())
            ->with(['program'])
            ->withCount('participants')
            ->latest()
            ->paginate(10);

        $instructorId = auth()->id();
        $classIds = ClassModel::where('instructor_id', $instructorId)->pluck('id');

        $totalClasses = $classIds->count();

        $activeClasses = ClassModel::where('instructor_id', $instructorId)
            ->where('status', 'active')
            ->count();

        $totalStudents = ClassParticipant::whereIn('class_id', $classIds)->count();

        return view(
            'instruktur.classes.index',
            compact(
                'classes',
                'totalClasses',
                'activeClasses',
                'totalStudents'
            )
        );
    }

    public function addStudentForm(ClassModel $class)
    {
        $this->authorizeInstructor($class);

        $class->load(['program', 'instructor', 'participants.participant']);

        $participants = $class->participants()
            ->with('participant')
            ->paginate(15);

        $enrolledIds = $class->participants()->pluck('participant_id')->toArray();

        $availableStudents = User::where('role', 'peserta')
            ->where('is_active', true)
            ->where('approval_status', 'approved')
            ->whereNotIn('id', $enrolledIds)
            ->get();

        return view(
            'instruktur.classes.add-student',
            compact('class', 'availableStudents', 'participants')
        );
    }

    public function addStudent(Request $request, ClassModel $class)
    {
        $this->authorizeInstructor($class);

        $validated = $request->validate([
            'participant_ids' => 'required|array|min:1',
            'participant_ids.*' => [
                'required',
                'integer',
                \Illuminate\Validation\Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'peserta')
                        ->where('is_active', true)
                        ->where('approval_status', 'approved');
                }),
            ],
        ]);

        $participantIds = array_map('intval', $validated['participant_ids']);
        $existingIds = ClassParticipant::where('class_id', $class->id)
            ->whereIn('participant_id', $participantIds)
            ->pluck('participant_id')
            ->all();

        $now = now();
        $rows = collect($participantIds)
            ->diff($existingIds)
            ->map(fn (int $participantId) => [
                'class_id' => $class->id,
                'participant_id' => $participantId,
                'enrolled_at' => $now,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ])
            ->values()
            ->all();

        if ($rows !== []) {
            ClassParticipant::insert($rows);
        }

        return redirect()
            ->route('instruktur.classes.add-student', $class)
            ->with('success', __('lms.flash.student_added'));
    }

    public function removeStudent(ClassModel $class, ClassParticipant $participant)
    {
        $this->authorizeInstructor($class);

        $this->ensureBelongsToClass($participant, $class);

        $participant->delete();

        return redirect()
            ->route('instruktur.classes.add-student', $class)
            ->with('success', __('lms.flash.student_removed'));
    }

    public function updateStudentStatus(Request $request, ClassModel $class, ClassParticipant $participant)
    {
        $this->authorizeInstructor($class);

        $this->ensureBelongsToClass($participant, $class);

        $validated = $request->validate([
            'status' => 'required|in:active,completed,dropped',
        ]);

        $participant->update($validated);

        return redirect()
            ->route('instruktur.classes.add-student', $class)
            ->with('success', __('lms.flash.student_status_updated'));
    }
}
