<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'answer_data',
        'is_correct',
        'submitted_at',
    ];

    protected $casts = [
        'answer_data' => 'array',
        'is_correct' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
} 