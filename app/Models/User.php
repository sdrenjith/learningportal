<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'father_name',
        'mother_name',
        'dob',
        'course_fee',
        'phone',
        'gender',
        'nationality',
        'category',
        'batch_id',
        'username',
        'attachments',
        'profile_picture',
        'qualification',
        'experience_months',
        'address',
        'passport_number',
        'fees_paid',
        'balance_fees_due',
        'father_whatsapp',
        'mother_whatsapp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
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
            'password' => 'hashed',
            'attachments' => 'array',
            'dob' => 'date',
        ];
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a datamanager.
     */
    public function isDataManager(): bool
    {
        return $this->role === 'datamanager';
    }

    /**
     * Check if the user is a teacher.
     */
    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function assignedCourses()
    {
        return $this->batch ? $this->batch->courses : collect();
    }

    public function assignedDays()
    {
        return $this->batch ? $this->batch->days : collect();
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    public function batches()
    {
        return $this->hasMany(Batch::class, 'teacher_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->isAdmin();
        }

        if ($panel->getId() === 'student') {
            return $this->role === 'student';
        }

        return false;
    }
}
