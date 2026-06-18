<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// #[Fillable(['name', 'email', 'password'])]
// #[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

     protected $fillable = [
        'role',
        'name',
        'email',
        'password',
        'nik',
        'phone',
        'gender',
        'birth_place',
        'birth_date',
        'address',
        'photo',
        'bio',
        'is_active',
        'approval_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birth_date' => 'date',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }
    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'instructor_id');
    }

    public function classParticipants()
    {
        return $this->hasMany(ClassParticipant::class, 'participant_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'participant_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'participant_id');
    }

    public function finalGrades()
    {
        return $this->hasMany(FinalGrade::class, 'participant_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'participant_id');
    }

}
