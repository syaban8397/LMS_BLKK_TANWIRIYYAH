<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'class_id',
        'participant_id',
        'meeting_number',
        'attendance_date',
        'status',
        'created_by',
        'notes',
        'check_in_time',
    ];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'datetime',
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
}