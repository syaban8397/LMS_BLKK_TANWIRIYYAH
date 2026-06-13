<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Assignment extends Model
{
    protected $fillable = [
        'class_id',
        'title',
        'description',
        'attachment',
        'deadline',
        'late_submission_allowed',
        'is_active',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
            'late_submission_allowed' => 'boolean',
        ];
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    // TAMBAHKAN RELASI INI
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