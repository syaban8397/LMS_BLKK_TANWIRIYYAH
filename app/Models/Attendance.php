<?php
// app/Models/Attendance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    
    protected $fillable = [
        'class_id',
        'participant_id',
        'meeting_number',
        'attendance_date',
        'status',
        'submission_type',
        'notes',
        'check_in_time',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
            'check_in_time' => 'datetime',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}