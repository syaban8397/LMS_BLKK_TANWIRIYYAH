<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'class_id',
        'title',
        'material_code',
        'description',
        'meeting_number',
        'file_path',
        'file_type',
        'youtube_url',
        'created_by',
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function progressRecords()
    {
        return $this->hasMany(MaterialProgress::class);
    }
}