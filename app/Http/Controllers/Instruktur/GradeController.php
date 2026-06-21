<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Concerns\AuthorizesInstructorClass;
use App\Http\Controllers\Concerns\EnsuresNestedResourceBelongsToClass;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\ClassModel;
use App\Models\FinalGrade;
use App\Models\Submission;
use App\Http\Requests\Instruktur\StoreGradeRequest;

class GradeController extends Controller
{
    use AuthorizesInstructorClass;
    use EnsuresNestedResourceBelongsToClass;

    public function index(ClassModel $class, Assignment $assignment)
    {
        $this->authorizeInstructor($class);
        $this->ensureBelongsToClass($assignment, $class);

        $submissions = Submission::where('assignment_id', $assignment->id)
            ->with('participant')
            ->orderBy('submitted_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => $submissions->total(),
            'submitted' => Submission::where('assignment_id', $assignment->id)->where('status', 'submitted')->count(),
            'late' => Submission::where('assignment_id', $assignment->id)->where('status', 'late')->count(),
            'graded' => Submission::where('assignment_id', $assignment->id)->where('status', 'graded')->count(),
        ];

        return view('instruktur.grades.index', compact('class', 'assignment', 'submissions', 'stats'));
    }

    public function show(ClassModel $class, Assignment $assignment, Submission $submission)
    {
        $this->authorizeInstructor($class);
        $this->ensureSubmissionBelongsToAssignment($assignment, $class, $submission);
        $submission->load('participant');

        return view('instruktur.grades.show', compact('class', 'assignment', 'submission'));
    }

    public function storeGrade(StoreGradeRequest $request, ClassModel $class, Assignment $assignment, Submission $submission)
    {
        $this->authorizeInstructor($class);
        $this->ensureSubmissionBelongsToAssignment($assignment, $class, $submission);

        $validated = $request->validated();

        $submission->update([
            'score' => $validated['score'],
            'feedback' => $validated['feedback'],
            'status' => 'graded',
        ]);

        $this->updateFinalGrade($class, $submission->participant_id);

        return redirect()->route('instruktur.grades.index', [$class, $assignment])
            ->with('success', __('lms.flash.grade_saved'));
    }

    protected function ensureSubmissionBelongsToAssignment(
        Assignment $assignment,
        ClassModel $class,
        Submission $submission
    ): void {
        $this->ensureBelongsToClass($assignment, $class);

        if ($submission->assignment_id !== $assignment->id) {
            abort(404);
        }
    }

    protected function updateFinalGrade(ClassModel $class, $participantId)
    {
        $submissions = Submission::whereHas('assignment', fn ($q) => $q->where('class_id', $class->id))
            ->where('participant_id', $participantId)
            ->where('status', 'graded')
            ->get();

        if ($submissions->isEmpty()) {
            return;
        }

        $average = $submissions->avg('score');

        $finalGrade = FinalGrade::firstOrNew([
            'class_id' => $class->id,
            'participant_id' => $participantId,
        ]);

        $finalGrade->assignment_score = $average;
        $finalGrade->final_score = ($average * 0.7) + ($finalGrade->attendance_score * 0.3);
        $finalGrade->status = $finalGrade->final_score >= 70 ? 'pass' : 'fail';
        $finalGrade->save();
    }
}
