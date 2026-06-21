<?php

namespace App\Models;

use App\Support\UploadRules;
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

    protected function casts(): array
    {
        return [
            'meeting_number' => 'integer',
        ];
    }

    public static function validationRules(): array
    {
        return [
            'title' => 'required|max:255',
            'material_code' => 'nullable|max:50',
            'description' => 'nullable|string',
            'meeting_number' => 'required|integer|min:1',
            'file' => UploadRules::documentAttachment(),
            'youtube_url' => 'nullable|url|max:255',
        ];
    }

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