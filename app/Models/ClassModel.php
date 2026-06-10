<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'program_id',
        'instructor_id',
        'code',
        'title',
        'description',
        'start_date',
        'end_date',
        'quota',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function participants()
    {
        return $this->hasMany(ClassParticipant::class, 'class_id');
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'class_id', 'id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'class_id', 'id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'class_id', 'id');
    }

    public function finalGrades()
    {
        return $this->hasMany(FinalGrade::class, 'class_id', 'id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'class_id', 'id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'class_id', 'id');
    }
}