<?php

namespace App\Filament\Resources\BatchResource\Pages;

use App\Filament\Resources\BatchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBatch extends EditRecord
{
    protected static string $resource = BatchResource::class;

    protected array $toggleStates = [];

    /**
     * Get available days based on user role
     */
    protected function getAvailableDays()
    {
        if (auth()->user()->isTeacher()) {
            // For teachers: only show days that have questions for their assigned subjects
            $teacherSubjectIds = auth()->user()->subjects()->pluck('id')->toArray();
            
            if (empty($teacherSubjectIds)) {
                return collect(); // No subjects assigned, no days to show
            }
            
            return \App\Models\Day::whereHas('questions', function ($query) use ($teacherSubjectIds) {
                $query->whereIn('subject_id', $teacherSubjectIds);
            })->get();
        } else {
            // For admins: show all days that have questions
            return \App\Models\Day::whereHas('questions')->get();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $batch = $this->record;
        
        // Set course toggles based on current assignments
        $assignedCourseIds = $batch->courses->pluck('id')->toArray();
        $data['course_1'] = in_array(1, $assignedCourseIds);
        $data['course_2'] = in_array(2, $assignedCourseIds);
        $data['course_3'] = in_array(3, $assignedCourseIds);
        $data['course_4'] = in_array(4, $assignedCourseIds);
        
        // Handle active_day_ids field (ensure it's properly set)
        if (auth()->user()->isTeacher()) {
            // For teachers: filter active days to only their relevant ones
            $teacherSubjectIds = auth()->user()->subjects()->pluck('id')->toArray();
            
            if (!empty($teacherSubjectIds) && !empty($batch->active_day_ids)) {
                $relevantActiveDayIds = \App\Models\Day::whereIn('id', $batch->active_day_ids)
                    ->whereHas('questions', function ($query) use ($teacherSubjectIds) {
                        $query->whereIn('subject_id', $teacherSubjectIds);
                    })
                    ->pluck('id')
                    ->toArray();
                
                $data['active_day_ids'] = $relevantActiveDayIds;
            } else {
                $data['active_day_ids'] = [];
            }
        } else {
            // For admins: keep all active days
            $data['active_day_ids'] = $batch->active_day_ids ?? [];
        }
        
        // Set day toggles based on assignment AND completion status
        $assignedDayIds = $batch->days->pluck('id')->toArray();
        $availableDays = $this->getAvailableDays();
        
        foreach ($availableDays as $day) {
            // Toggle is ON only if day is both assigned AND completed
            $isAssigned = in_array($day->id, $assignedDayIds);
            $isCompleted = $batch->dayProgress()
                ->where('day_id', $day->id)
                ->where('is_completed', true)
                ->exists();
            
            $data["day_{$day->id}"] = $isAssigned && $isCompleted;
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Store toggle states for later use in afterSave
        $this->toggleStates = [];
        
        // Store course toggle states
        $this->toggleStates['course_1'] = $data['course_1'] ?? false;
        $this->toggleStates['course_2'] = $data['course_2'] ?? false;
        $this->toggleStates['course_3'] = $data['course_3'] ?? false;
        $this->toggleStates['course_4'] = $data['course_4'] ?? false;
        
        // Store day toggle states (toggle ON means assigned AND completed)
        $availableDays = $this->getAvailableDays();
        foreach ($availableDays as $day) {
            $this->toggleStates["day_{$day->id}"] = $data["day_{$day->id}"] ?? false;
        }
        
        // Remove toggle fields from data as they're not part of the model
        foreach (['course_1', 'course_2', 'course_3', 'course_4'] as $field) {
            unset($data[$field]);
        }
        foreach ($availableDays as $day) {
            unset($data["day_{$day->id}"]);
        }
        
        return $data;
    }

    protected function afterSave(): void
    {
        $batch = $this->record;
        
        // Handle course assignments
        $selectedCourseIds = [];
        foreach ([1, 2, 3, 4] as $courseId) {
            if ($this->toggleStates["course_{$courseId}"] ?? false) {
                $selectedCourseIds[] = $courseId;
            }
        }
        $batch->courses()->sync($selectedCourseIds);
        
        // Handle day assignments and completion
        $selectedDayIds = [];
        $availableDays = $this->getAvailableDays();
        
        foreach ($availableDays as $day) {
            $isToggleOn = $this->toggleStates["day_{$day->id}"] ?? false;
            
            if ($isToggleOn) {
                // Toggle is ON: assign day AND mark as completed
                $selectedDayIds[] = $day->id;
                
                // Mark as completed
                $batch->dayProgress()->updateOrCreate(
                    ['day_id' => $day->id],
                    [
                        'is_completed' => true,
                        'completed_at' => now(),
                        'completed_by' => auth()->id()
                    ]
                );
            } else {
                // Toggle is OFF: remove assignment and completion entirely
                $batch->dayProgress()->where('day_id', $day->id)->delete();
            }
        }
        
        // Sync day assignments (only assign days that are toggled ON)
        $batch->days()->sync($selectedDayIds);
    }
}
