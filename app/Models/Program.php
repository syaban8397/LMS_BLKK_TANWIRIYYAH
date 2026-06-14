<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name',
        'description',
        'certificate_degree',
        'validity_years',
        'start_date',
        'end_date',
        'status',
        'capacity',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'validity_years' => 'integer',
            'capacity' => 'integer',
        ];
    }

    public function classes()
    {
        return $this->hasMany(ClassModel::class);
    }

    public static function certificateDegreeOptions(): array
    {
        return config('certificate.degrees', []);
    }

    public static function certificateDegreeCodes(): array
    {
        return array_keys(self::certificateDegreeOptions());
    }

    public static function validationRules(): array
    {
        return [
            'name' => 'required|max:255',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
            'certificate_degree' => 'nullable|in:' . implode(',', self::certificateDegreeCodes()),
            'validity_years' => 'nullable|integer|min:1|max:10',
            'capacity' => 'required|integer|min:1|max:999',
        ];
    }

    public function getCertificateDegreeLabelAttribute(): string
    {
        $degrees = self::certificateDegreeOptions();

        if ($this->certificate_degree && isset($degrees[$this->certificate_degree])) {
            return $degrees[$this->certificate_degree]['title'];
        }

        return $this->certificate_degree ?? config('certificate.default_degree');
    }

    public function classCount(): int
    {
        return $this->classes()->count();
    }

    public function remainingClassSlots(?int $excludeClassId = null): int
    {
        $query = $this->classes();

        if ($excludeClassId) {
            $query->where('id', '!=', $excludeClassId);
        }

        return max(0, $this->capacity - $query->count());
    }

    public function hasAvailableClassSlot(?int $excludeClassId = null): bool
    {
        return $this->remainingClassSlots($excludeClassId) > 0;
    }

    public function ensureHasAvailableClassSlot(): void
    {
        if ($this->hasAvailableClassSlot()) {
            return;
        }

        throw \Illuminate\Validation\ValidationException::withMessages([
            'program_id' => 'Program "' . $this->name . '" sudah penuh. Maksimal ' . $this->capacity . ' kelas.',
        ]);
    }
}