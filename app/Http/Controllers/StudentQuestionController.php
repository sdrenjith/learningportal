<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class StudentQuestionController extends Controller
{
    public function answer($id, Request $request)
    {
        $question = Question::findOrFail($id);
        
        // Check if student has access to this course through their batch
        $user = auth()->user();
        $assignedCourseIds = $user->assignedCourses()->pluck('id')->toArray();
        $assignedDayIds = $user->assignedDays()->pluck('id')->toArray();
        
        if (!in_array($question->course_id, $assignedCourseIds)) {
            return redirect()->route('filament.student.pages.courses')
                ->with('error', 'You do not have access to this course. Please contact your administrator.');
        }
        
        if (!in_array($question->day_id, $assignedDayIds)) {
            return redirect()->route('filament.student.pages.courses')
                ->with('error', 'You do not have access to this day. Please contact your administrator.');
        }
        
        // Always show fresh form for re-attempts - don't load previous answers
        $studentAnswer = null;
        $editMode = false;
        return view('filament.student.pages.answer-question', compact('question', 'studentAnswer', 'editMode'));
    }

    public function submitAnswer(Request $request, $id)
    {
        $question = \App\Models\Question::findOrFail($id);
        
        // Check if student has access to this course and day through their batch
        $user = auth()->user();
        $assignedCourseIds = $user->assignedCourses()->pluck('id')->toArray();
        $assignedDayIds = $user->assignedDays()->pluck('id')->toArray();
        
        if (!in_array($question->course_id, $assignedCourseIds)) {
            return redirect()->route('filament.student.pages.courses')
                ->with('error', 'You do not have access to this course. Please contact your administrator.');
        }
        
        if (!in_array($question->day_id, $assignedDayIds)) {
            return redirect()->route('filament.student.pages.courses')
                ->with('error', 'You do not have access to this day. Please contact your administrator.');
        }
        
        $data = $request->except(['_token']);

        // Save answer
        $wasUpdated = \DB::table('student_answers')->where('user_id', $user->id)->where('question_id', $question->id)->exists();
        \DB::table('student_answers')->updateOrInsert(
            [
                'user_id' => $user->id,
                'question_id' => $question->id,
            ],
            [
                'answer_data' => json_encode($data['answer'] ?? $data),
                'submitted_at' => now(),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $msg = $wasUpdated ? 'Your answer has been updated!' : 'Your answer has been submitted!';
        return redirect()->back()->with('success', $msg);
    }
} 