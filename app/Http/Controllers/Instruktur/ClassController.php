<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Concerns\AuthorizesInstructorClass;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassParticipant;
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    use AuthorizesInstructorClass;

    public function index()
    {
        $classes = ClassModel::where('instructor_id', auth()->id())
            ->with(['program', 'participants'])
            ->latest()
            ->paginate(10);

        $totalClasses = ClassModel::where('instructor_id', auth()->id())->count();

        $activeClasses = ClassModel::where('instructor_id', auth()->id())
            ->where('status', 'active')
            ->count();

        $totalStudents = ClassParticipant::whereIn(
            'class_id',
            ClassModel::where('instructor_id', auth()->id())->pluck('id')
        )->count();

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

    public function show(ClassModel $class)
    {
        $this->authorizeInstructor($class);

        $class->load(['program', 'instructor', 'participants.participant']);

        $participants = $class->participants()
            ->with('participant')
            ->paginate(15);

        return view(
            'instruktur.classes.show',
            compact('class', 'participants')
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
            'participant_ids.*' => 'required|exists:users,id',
        ]);

        foreach ($validated['participant_ids'] as $participantId) {
            // Check if already enrolled
            $exists = ClassParticipant::where('class_id', $class->id)
                ->where('participant_id', $participantId)
                ->exists();

            if (!$exists) {
                ClassParticipant::create([
                    'class_id' => $class->id,
                    'participant_id' => $participantId,
                    'enrolled_at' => now(),
                    'status' => 'active',
                ]);
            }
        }

        return redirect()
            ->route('instruktur.classes.add-student', $class)
            ->with('success', __('lms.flash.student_added'));
    }

    public function removeStudent(ClassModel $class, ClassParticipant $participant)
    {
        $this->authorizeInstructor($class);

        if ($participant->class_id !== $class->id) {
            abort(404);
        }

        $participant->delete();

        return redirect()
            ->route('instruktur.classes.add-student', $class)
            ->with('success', __('lms.flash.student_removed'));
    }

    public function updateStudentStatus(Request $request, ClassModel $class, ClassParticipant $participant)
    {
        $this->authorizeInstructor($class);

        if ($participant->class_id !== $class->id) {
            abort(404);
        }

        $validated = $request->validate([
            'status' => 'required|in:active,completed,dropped',
        ]);

        $participant->update($validated);

        return redirect()
            ->route('instruktur.classes.add-student', $class)
            ->with('success', __('lms.flash.student_status_updated'));
    }
}
