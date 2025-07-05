<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'name',
        'description',
        'teacher_id',
        'active_day_ids',
    ];

    protected $casts = [
        'active_day_ids' => 'array',
    ];

    public function students()
    {
        return $this->hasMany(User::class, 'batch_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'batch_course');
    }

    public function days()
    {
        return $this->belongsToMany(Day::class, 'batch_day');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function activeDays()
    {
        if (empty($this->active_day_ids)) {
            return Day::whereIn('id', []); // Return empty query
        }
        return Day::whereIn('id', $this->active_day_ids);
    }

    public function getActiveDaysAttribute()
    {
        return $this->activeDays()->with('course')->get();
    }

    // Keep for backward compatibility with single active day
    public function activeDay()
    {
        if (empty($this->active_day_ids)) {
            return null;
        }
        return Day::find($this->active_day_ids[0]);
    }

    public function dayProgress()
    {
        return $this->hasMany(BatchDayProgress::class);
    }

    public function completedDays()
    {
        return $this->dayProgress()->where('is_completed', true);
    }

    /**
     * Get progress percentage for teacher (only their assigned days)
     */
    public function getTeacherProgressPercentage($teacherId)
    {
        $teacher = User::find($teacherId);
        if (!$teacher || !$teacher->isTeacher()) {
            return 0;
        }

        $teacherSubjectIds = $teacher->subjects()->pluck('id')->toArray();
        if (empty($teacherSubjectIds)) {
            return 0;
        }

        // Get days assigned to this batch that have questions for teacher's subjects
        $relevantDayIds = $this->days()
            ->whereHas('questions', function ($query) use ($teacherSubjectIds) {
                $query->whereIn('subject_id', $teacherSubjectIds);
            })
            ->pluck('days.id')
            ->toArray();

        if (empty($relevantDayIds)) {
            return 0;
        }

        $totalRelevantDays = count($relevantDayIds);
        $completedRelevantDays = $this->dayProgress()
            ->whereIn('day_id', $relevantDayIds)
            ->where('is_completed', true)
            ->count();

        return $totalRelevantDays > 0 ? round(($completedRelevantDays / $totalRelevantDays) * 100, 1) : 0;
    }

    /**
     * Get overall progress percentage for admin (all available days with questions)
     */
    public function getOverallProgressPercentage()
    {
        // Get all days that have questions (available days)
        $totalAvailableDays = \App\Models\Day::whereHas('questions')->count();
        
        if ($totalAvailableDays === 0) {
            return 0;
        }

        // Get all days that have questions and are marked as completed for this batch
        $completedAvailableDays = $this->dayProgress()
            ->whereHas('day', function ($query) {
                $query->whereHas('questions');
            })
            ->where('is_completed', true)
            ->count();

        return round(($completedAvailableDays / $totalAvailableDays) * 100, 1);
    }
}
