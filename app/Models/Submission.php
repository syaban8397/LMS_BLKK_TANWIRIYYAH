<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'assignment_id',
        'participant_id',
        'url',
        'file_path',
        'notes',
        'score',
        'feedback',
        'submitted_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'score' => 'decimal:2',
        ];
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id');
    }

    public function isGraded()
    {
        return $this->status === 'graded' || !is_null($this->score);
    }

    public function isLate()
    {
        if (!$this->assignment->deadline) return false;
        return $this->submitted_at > $this->assignment->deadline;
    }
}