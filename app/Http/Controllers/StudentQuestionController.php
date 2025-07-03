<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class StudentQuestionController extends Controller
{
    public function answer($id, Request $request)
    {
        $question = Question::findOrFail($id);
        $studentAnswer = null;
        if (auth()->check()) {
            $studentAnswer = \DB::table('student_answers')
                ->where('user_id', auth()->id())
                ->where('question_id', $question->id)
                ->first();
        }
        $editMode = $request->query('edit') == 1;
        return view('filament.student.pages.answer-question', compact('question', 'studentAnswer', 'editMode'));
    }

    public function submitAnswer(Request $request, $id)
    {
        $question = \App\Models\Question::findOrFail($id);
        $user = auth()->user();
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