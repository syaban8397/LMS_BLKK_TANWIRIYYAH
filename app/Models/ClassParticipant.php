<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassParticipant extends Model
{
    protected $fillable = [
        'class_id',
        'participant_id',
        'enrolled_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'enrolled_at' => 'datetime',
        ];
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id');
    }
}