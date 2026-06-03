<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'participant_id',
        'title',
        'description',
        'image',
        'github_url',
        'demo_url',
        'technologies',
    ];

    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id');
    }
}