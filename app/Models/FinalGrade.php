<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalGrade extends Model
{
    protected $fillable = [
        'class_id',
        'participant_id',
        'assignment_score',
        'attendance_score',
        'final_score',
        'feedback',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'assignment_score' => 'float',
            'attendance_score' => 'float',
            'final_score' => 'float',
        ];
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id');
    }
}