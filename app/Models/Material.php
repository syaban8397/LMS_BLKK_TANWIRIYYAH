<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'class_id',
        'title',
        'description',
        'meeting_number',
        'file_path',
        'file_type',
        'youtube_url',
        'created_by',
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}