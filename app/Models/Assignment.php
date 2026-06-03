<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'class_id',
        'title',
        'description',
        'attachment',
        'deadline',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
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
}