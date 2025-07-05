<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'course_id', 'teacher_id'];

    public function days()
    {
        return $this->hasMany(Day::class, 'course_id', 'course_id');
    }

    public function questions()
    {
        return $this->hasMany(\App\Models\Question::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
