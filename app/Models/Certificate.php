<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'participant_id',
        'class_id',
        'certificate_number',
        'final_score',
        'attendance_percentage',
        'qr_code',
        'pdf_file',
        'issued_at',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
        ];
    }

    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }
}