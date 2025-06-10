<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name'];

    public function days()
    {
        return $this->hasMany(Day::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
