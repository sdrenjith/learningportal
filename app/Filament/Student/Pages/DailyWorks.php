<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class DailyWorks extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string $view = 'filament.student.pages.daily-works';

    protected static ?string $title = 'Daily Works';

    protected static ?string $navigationLabel = 'Daily Works';

    protected static ?string $slug = 'daily-works';

    public static function getRouteName(?string $panel = null): string
    {
        return 'filament.student.pages.daily-works';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public function getViewData(): array
    {
        $user = Auth::user();
        
        // Get assigned courses and days
        $assignedCourses = $user->assignedCourses();
        $assignedDays = $user->assignedDays();
        $assignedDayIds = $assignedDays->pluck('id')->toArray();
        
        // Get answered questions for progress tracking
        $answeredQuestionIds = \App\Models\StudentAnswer::where('user_id', $user->id)->pluck('question_id')->toArray();
        
        // Find the active day (first incomplete day)
        $activeDay = null;
        $activeDayQuestions = collect();
        
        foreach ($assignedDays->sortBy('day_number') as $day) {
            $dayQuestions = \App\Models\Question::where('day_id', $day->id)
                ->where('is_active', true)
                ->with(['subject', 'course'])
                ->get();
            
            $dayAnsweredCount = $dayQuestions->filter(function($q) use ($answeredQuestionIds) {
                return in_array($q->id, $answeredQuestionIds);
            })->count();
            
            $isCompleted = $dayQuestions->count() > 0 && $dayAnsweredCount == $dayQuestions->count();
            
            // If this day is not completed, it's our active day
            if (!$isCompleted && $dayQuestions->count() > 0) {
                $activeDay = $day;
                $activeDayQuestions = $dayQuestions;
                break;
            }
        }
        
        // If no incomplete day found, use the first assigned day
        if (!$activeDay && $assignedDays->count() > 0) {
            $activeDay = $assignedDays->sortBy('day_number')->first();
            $activeDayQuestions = \App\Models\Question::where('day_id', $activeDay->id)
                ->where('is_active', true)
                ->with(['subject', 'course'])
                ->get();
        }
        
        return [
            'user' => $user,
            'assignedCourses' => $assignedCourses,
            'assignedDays' => $assignedDays,
            'answeredQuestionIds' => $answeredQuestionIds,
            'activeDay' => $activeDay,
            'activeDayQuestions' => $activeDayQuestions,
        ];
    }
} 