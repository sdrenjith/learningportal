<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'day_id',
        'level_id',
        'subject_id',
        'question_type_id',
        'instruction',
        'question_data',
        'answer_data',
        'explanation',
        'points',
        'course_id',
        'left_options',
        'right_options',
        'correct_pairs',
        'is_active',
    ];

    protected $casts = [
        'question_data' => 'array',
        'answer_data' => 'array',
        'left_options' => 'array',
        'right_options' => 'array',
        'correct_pairs' => 'array',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function questionType()
    {
        return $this->belongsTo(QuestionType::class);
    }

    public function media()
    {
        return $this->hasMany(QuestionMedia::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
