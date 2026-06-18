<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\AuthorizesInstructorClass;
use App\Models\Assignment;
use App\Models\ClassModel;
use App\Models\Material;
use App\Models\Submission;
use App\Models\User;
use App\Support\SecureStorage;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SecureFileController extends Controller
{
    use AuthorizesInstructorClass;

    public function userPhoto(User $user): BinaryFileResponse
    {
        $viewer = auth()->user();

        if (!$this->canViewUserPhoto($viewer, $user)) {
            abort(403);
        }

        return $this->streamFile($user->photo, basename($user->photo ?? 'photo.jpg'));
    }

    public function assignmentAttachment(ClassModel $class, Assignment $assignment): BinaryFileResponse
    {
        if ($assignment->class_id !== $class->id) {
            abort(404);
        }

        $this->authorizeFileAccess($class);

        return $this->streamFile(
            $assignment->attachment,
            basename($assignment->attachment ?? 'attachment')
        );
    }

    public function materialFile(ClassModel $class, Material $material): BinaryFileResponse
    {
        if ($material->class_id !== $class->id) {
            abort(404);
        }

        $this->authorizeFileAccess($class);

        return $this->streamFile(
            $material->file_path,
            basename($material->file_path ?? 'material')
        );
    }

    public function submissionFile(ClassModel $class, Assignment $assignment, Submission $submission): BinaryFileResponse
    {
        if ($assignment->class_id !== $class->id || $submission->assignment_id !== $assignment->id) {
            abort(404);
        }

        $user = auth()->user();

        if ($user->role === 'peserta' && $submission->participant_id !== $user->id) {
            abort(403);
        }

        if ($user->role === 'instruktur') {
            $this->authorizeInstructor($class);
        } elseif ($user->role === 'admin') {
            // allowed
        } elseif ($user->role === 'peserta') {
            $this->authorizeActiveEnrollment($class);
        } else {
            abort(403);
        }

        return $this->streamFile(
            $submission->file_path,
            basename($submission->file_path ?? 'submission')
        );
    }

    protected function authorizeFileAccess(ClassModel $class): void
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return;
        }

        if ($user->role === 'instruktur') {
            $this->authorizeInstructor($class);

            return;
        }

        if ($user->role === 'peserta') {
            $this->authorizeActiveEnrollment($class);

            return;
        }

        abort(403);
    }

    protected function authorizeActiveEnrollment(ClassModel $class): void
    {
        $isEnrolled = $class->participants()
            ->where('participant_id', auth()->id())
            ->where('status', 'active')
            ->exists();

        if (!$isEnrolled) {
            abort(403, __('lms.access.not_enrolled'));
        }
    }

    protected function canViewUserPhoto(User $viewer, User $subject): bool
    {
        if ($viewer->id === $subject->id || $viewer->role === 'admin') {
            return true;
        }

        if ($viewer->role === 'instruktur' && $subject->role === 'peserta') {
            return $subject->classParticipants()
                ->whereIn('class_id', $viewer->classes()->pluck('id'))
                ->exists();
        }

        return false;
    }

    protected function streamFile(?string $path, string $downloadName): BinaryFileResponse
    {
        $path = SecureStorage::normalizePath($path);

        if (!$path || !SecureStorage::exists($path)) {
            abort(404, __('lms.access.file_not_found'));
        }

        $fullPath = SecureStorage::path($path);

        if (Storage::disk(SecureStorage::DISK)->exists($path)) {
            $mime = Storage::disk(SecureStorage::DISK)->mimeType($path);
        } else {
            $mime = Storage::disk(SecureStorage::LEGACY_DISK)->mimeType($path);
        }

        return response()->file($fullPath, [
            'Content-Type' => $mime ?: 'application/octet-stream',
            'Content-Disposition' => 'inline; filename="' . $downloadName . '"',
        ]);
    }
}
