<?php

namespace App\Models;

use App\Support\UploadRules;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'class_id',
        'title',
        'description',
        'attachment',
        'deadline',
        'late_submission_allowed',
        'submission_type',
        'is_active',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
            'late_submission_allowed' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public static function validationRules(?string $submissionType = null): array
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'attachment' => UploadRules::documentAttachment(),
            'deadline' => 'required|date_format:Y-m-d\TH:i',
            'late_submission_allowed' => 'sometimes|boolean',
            'submission_type' => 'required|in:file,link,file_and_link',
        ];
    }

    public function requiresFileSubmission(): bool
    {
        return in_array($this->submission_type, ['file', 'file_and_link'], true);
    }

    public function requiresLinkSubmission(): bool
    {
        return in_array($this->submission_type, ['link', 'file_and_link'], true);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isDeadlinePassed()
    {
        return Carbon::now()->gt($this->deadline);
    }

    public function canSubmitAfterDeadline(): bool
    {
        return (bool) $this->late_submission_allowed;
    }

    public function allowsSubmission(): bool
    {
        return $this->deadline->isFuture() || $this->canSubmitAfterDeadline();
    }
}