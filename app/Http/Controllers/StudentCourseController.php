<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function index()
    {
        $courses = \App\Models\Course::with(['days.questions'])->get();
        $answeredQuestionIds = [];
        if (auth()->check()) {
            $answeredQuestionIds = \DB::table('student_answers')
                ->where('user_id', auth()->id())
                ->pluck('question_id')
                ->toArray();
        }
        return view('filament.student.pages.courses', compact('courses', 'answeredQuestionIds'));
    }
} 