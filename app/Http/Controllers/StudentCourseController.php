<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get only assigned courses instead of all courses
        $assignedCourses = $user->assignedCourses();
        $assignedCourseIds = $assignedCourses->pluck('id')->toArray();
        
        $assignedDays = $user->assignedDays();
        $assignedDayIds = $assignedDays->pluck('id')->toArray();
        
        // Filter subjects based on user role
        if (auth()->check() && auth()->user()->isTeacher()) {
            $subjects = auth()->user()->subjects;
        } else {
            $subjects = \App\Models\Subject::all();
        }
        $questions = \App\Models\Question::all()->groupBy(function($q) {
            return $q->course_id . '-' . $q->subject_id . '-' . $q->day_id;
        });
        $answeredQuestionIds = [];
        if (auth()->check()) {
            $answeredQuestionIds = \DB::table('student_answers')
                ->where('user_id', auth()->id())
                ->pluck('question_id')
                ->toArray();
        }
        
        // Pass only assigned courses to the view
        return view('filament.student.pages.courses', compact('assignedCourses', 'assignedCourseIds', 'assignedDayIds', 'subjects', 'questions', 'answeredQuestionIds'));
    }

    public function questions(Request $request)
    {
        $courseId = $request->get('course');
        $subjectId = $request->get('subject');
        $dayId = $request->get('day');
        
        $user = auth()->user();
        $assignedCourseIds = $user->assignedCourses()->pluck('id')->toArray();
        $assignedDayIds = $user->assignedDays()->pluck('id')->toArray();
        
        // Check if student has access to this course and day
        if (!in_array($courseId, $assignedCourseIds)) {
            return redirect()->route('filament.student.pages.courses')
                ->with('error', 'You do not have access to this course. Please contact your administrator.');
        }
        
        if (!in_array($dayId, $assignedDayIds)) {
            return redirect()->route('filament.student.pages.courses')
                ->with('error', 'You do not have access to this day. Please contact your administrator.');
        }
        
        // Get the course, subject, and day details
        $course = \App\Models\Course::findOrFail($courseId);
        $subject = \App\Models\Subject::findOrFail($subjectId);
        $day = \App\Models\Day::findOrFail($dayId);
        
        // Get questions for this specific combination
        $questions = \App\Models\Question::where('course_id', $courseId)
            ->where('subject_id', $subjectId)
            ->where('day_id', $dayId)
            ->where('is_active', true)
            ->orderBy('id')
            ->get();
        
        // Get answered question IDs for this user
        $answeredQuestionIds = [];
        if (auth()->check()) {
            $answeredQuestionIds = \DB::table('student_answers')
                ->where('user_id', auth()->id())
                ->pluck('question_id')
                ->toArray();
        }
        
        return view('filament.student.pages.questions', compact('course', 'subject', 'day', 'questions', 'answeredQuestionIds'));
    }
} 