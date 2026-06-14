<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Concerns\AuthorizesInstructorClass;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\FinalGrade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    use AuthorizesInstructorClass;

    public function index(ClassModel $class, Assignment $assignment)
    {
        $this->authorizeInstructor($class);
        if ($assignment->class_id !== $class->id) abort(404);

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
        if ($assignment->class_id !== $class->id || $submission->assignment_id !== $assignment->id) abort(404);
        $submission->load('participant');
        return view('instruktur.grades.show', compact('class', 'assignment', 'submission'));
    }

    public function storeGrade(Request $request, ClassModel $class, Assignment $assignment, Submission $submission)
    {
        $this->authorizeInstructor($class);
        if ($assignment->class_id !== $class->id || $submission->assignment_id !== $assignment->id) abort(404);

        $validated = $request->validate([
            'score' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'score' => $validated['score'],
            'feedback' => $validated['feedback'],
            'status' => 'graded',
        ]);

        $this->updateFinalGrade($class, $submission->participant_id);

        return redirect()->route('instruktur.grades.index', [$class, $assignment])
            ->with('success', 'Grade saved.');
    }

    protected function updateFinalGrade(ClassModel $class, $participantId)
    {
        $submissions = Submission::whereHas('assignment', fn($q) => $q->where('class_id', $class->id))
            ->where('participant_id', $participantId)
            ->where('status', 'graded')
            ->get();

        if ($submissions->isEmpty()) return;

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