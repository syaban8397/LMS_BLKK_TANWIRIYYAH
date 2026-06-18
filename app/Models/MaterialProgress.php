<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialProgress extends Model
{
    protected $table = 'material_progress';

    protected $fillable = [
        'material_id',
        'participant_id',
        'status',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id');
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
