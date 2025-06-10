<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionMedia extends Model
{
    protected $fillable = [
        'question_id',
        'file_path',
        'media_type',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
