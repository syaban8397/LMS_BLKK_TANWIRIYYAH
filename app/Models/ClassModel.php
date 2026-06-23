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
        'start_time',
        'duration_minutes',
        'quota',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'duration_minutes' => 'integer',
        ];
    }

    public function scopeForInstructor($query, int $instructorId)
    {
        return $query->where('instructor_id', $instructorId);
    }

    public function scopeForParticipant($query, int $participantId)
    {
        return $query->whereHas('participants', function ($q) use ($participantId) {
            $q->where('participant_id', $participantId)->where('status', 'active');
        });
    }

    public function attendanceWindowForDate(\Carbon\Carbon|string $date): array
    {
        $date = \Carbon\Carbon::parse($date)->startOfDay();
        $time = $this->start_time ?? '08:00:00';
        $duration = (int) ($this->duration_minutes ?? 60);

        $opensAt = $date->copy()->setTimeFromTimeString($time);
        $closesAt = $opensAt->copy()->addMinutes($duration);

        return [$opensAt, $closesAt];
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

    public static function prefixFromTitle(string $title): string
    {
        $title = trim($title);
        $words = preg_split('/\s+/', $title) ?: [];
        $stopWords = ['to', 'the', 'a', 'an', 'and', 'of', 'in', 'dan', 'di', 'ke', 'dari', 'untuk', 'kelas', 'batch', 'class'];

        $letters = '';

        foreach ($words as $word) {
            $word = preg_replace('/[^a-zA-Z]/', '', $word);

            if ($word === '' || in_array(strtolower($word), $stopWords, true)) {
                continue;
            }

            $letters .= strtoupper(substr($word, 0, 1));

            if (strlen($letters) >= 3) {
                break;
            }
        }

        if (strlen($letters) < 3) {
            $firstWord = preg_replace('/[^a-zA-Z]/', '', $words[0] ?? '') ?: 'CLS';
            $letters = strtoupper(substr($firstWord . 'XXX', 0, 3));
        }

        return $letters;
    }

    public static function generateCode(string $title, ?int $excludeId = null): string
    {
        $prefix = self::prefixFromTitle($title);

        $query = self::query()->where('code', 'like', $prefix . '-%');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $maxSequence = 0;

        foreach ($query->pluck('code') as $code) {
            if (preg_match('/^' . preg_quote($prefix, '/') . '-(\d{4})$/', $code, $matches)) {
                $maxSequence = max($maxSequence, (int) $matches[1]);
            }
        }

        return $prefix . '-' . str_pad((string) ($maxSequence + 1), 4, '0', STR_PAD_LEFT);
    }
}