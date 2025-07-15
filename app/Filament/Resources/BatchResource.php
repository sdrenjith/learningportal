<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BatchResource\Pages;
use App\Filament\Resources\BatchResource\RelationManagers;
use App\Models\Batch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;

class BatchResource extends Resource
{
    protected static ?string $model = Batch::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('description')
                        ->label('Description')
                        ->maxLength(1000)
                        ->rows(3),
                    Forms\Components\Select::make('teacher_id')
                        ->label('Assigned Teacher')
                        ->options(fn () => \App\Models\User::where('role', 'teacher')->pluck('name', 'id')->toArray())
                        ->placeholder('Select a teacher')
                        ->helperText('Choose a teacher to assign to this batch')
                        ->visible(fn () => auth()->user()->isAdmin())
                        ->columnSpanFull(),
                    Forms\Components\Select::make('active_day_ids')
                        ->label('Currently Active Day')
                        ->options(function ($record) {
                            // Get days based on user role
                            if (auth()->user()->isTeacher()) {
                                // For teachers: only show days that have questions for their assigned subjects
                                $teacherSubjectIds = auth()->user()->subjects()->pluck('id')->toArray();
                                
                                if (empty($teacherSubjectIds)) {
                                    return []; // No subjects assigned, no days to show
                                }
                                
                                $days = \App\Models\Day::with('course')
                                    ->whereHas('questions', function ($query) use ($teacherSubjectIds) {
                                        $query->whereIn('subject_id', $teacherSubjectIds);
                                    })
                                    ->get();
                            } else {
                                // For admins: show all days that have questions
                                $days = \App\Models\Day::with('course')->whereHas('questions')->get();
                            }
                            
                            return $days->pluck('title_with_course', 'id')->toArray();
                        })
                        ->searchable()
                        ->multiple(fn() => !auth()->user()->isTeacher()) // Multiple for admins, single for teachers
                        ->placeholder(auth()->user()->isTeacher() ? 'Select active day' : 'Select active days')
                        ->helperText(auth()->user()->isTeacher() ? 'Select the day currently active for your students' : 'Select multiple active days for different teachers')
                        ->columnSpanFull(),
                    Forms\Components\Placeholder::make('courses_help')
                        ->label('')
                        ->content('📚 Select which courses students in this batch can access:')
                        ->columnSpanFull(),
                    Forms\Components\Section::make('Course Assignments')
                        ->description('Toggle on/off the courses that students in this batch should have access to')
                        ->schema([
                            Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\Toggle::make('course_1')
                                        ->label('A1 Course')
                                        ->default(fn ($record) => $record ? $record->courses->contains(1) : false)
                                        ->extraAttributes(['class' => 'custom-green-toggle']),
                                    Forms\Components\Toggle::make('course_2')
                                        ->label('A2 Course')
                                        ->default(fn ($record) => $record ? $record->courses->contains(2) : false)
                                        ->extraAttributes(['class' => 'custom-green-toggle']),
                                    Forms\Components\Toggle::make('course_3')
                                        ->label('B1 Course')
                                        ->default(fn ($record) => $record ? $record->courses->contains(3) : false)
                                        ->extraAttributes(['class' => 'custom-green-toggle']),
                                    Forms\Components\Toggle::make('course_4')
                                        ->label('B2 Course')
                                        ->default(fn ($record) => $record ? $record->courses->contains(4) : false)
                                        ->extraAttributes(['class' => 'custom-green-toggle']),
                                ])
                        ])
                        ->columnSpanFull(),
                    Forms\Components\Section::make('Day Status')
                        ->description('Toggle on/off the specific days that students in this batch should have access to. Toggling ON marks the day as completed.')
                        ->schema([
                            Forms\Components\Grid::make(3)
                                ->schema(function ($record) {
                                    // Get days based on user role
                                    if (auth()->user()->isTeacher()) {
                                        // For teachers: only show days that have questions for their assigned subjects
                                        $teacherSubjectIds = auth()->user()->subjects()->pluck('id')->toArray();
                                        
                                        if (empty($teacherSubjectIds)) {
                                            return []; // No subjects assigned, no days to show
                                        }
                                        
                                        $days = \App\Models\Day::with('course')
                                            ->whereHas('questions', function ($query) use ($teacherSubjectIds) {
                                                $query->whereIn('subject_id', $teacherSubjectIds);
                                            })
                                            ->get();
                                    } else {
                                        // For admins: show all days that have questions
                                        $days = \App\Models\Day::with('course')->whereHas('questions')->get();
                                    }
                                    
                                    return $days->map(function ($day) {
                                        return Forms\Components\Toggle::make("day_{$day->id}")
                                            ->label("{$day->course->name} - {$day->title}")
                                            ->default(function ($record) use ($day) {
                                                if (!$record) return false;
                                                // Toggle is ON if day is assigned AND completed
                                                return $record->days->contains($day->id) && 
                                                       $record->dayProgress()
                                                           ->where('day_id', $day->id)
                                                           ->where('is_completed', true)
                                                           ->exists();
                                            })
                                            ->extraAttributes(['class' => 'custom-green-toggle']);
                                    })->toArray();
                                })
                        ])
                        ->columnSpanFull(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->with(['courses', 'days', 'students', 'teacher']);
                
                // If user is a teacher, only show batches assigned to them
                if (auth()->user()->isTeacher()) {
                    $query->where('teacher_id', auth()->id());
                }
                
                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Assigned Teacher')
                    ->sortable()
                    ->searchable()
                    ->placeholder('No teacher assigned')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray'),
                Tables\Columns\TextColumn::make('courses.name')
                    ->label('Assigned Courses')
                    ->badge()
                    ->separator(',')
                    ->color('success')
                    ->wrap(),
                Tables\Columns\TextColumn::make('progress')
                    ->label('Progress')
                    ->getStateUsing(function ($record) {
                        if (auth()->user()->isTeacher()) {
                            return $record->getTeacherProgressPercentage(auth()->id()) . '%';
                        } else {
                            return $record->getOverallProgressPercentage() . '%';
                        }
                    })
                    ->color('info')
                    ->sortable(false),
                Tables\Columns\TextColumn::make('active_days')
                    ->label('Active Days')
                    ->getStateUsing(function ($record) {
                        if (empty($record->active_day_ids)) {
                            return 'No active days';
                        }
                        
                        $activeDays = $record->active_days;
                        if ($activeDays->isEmpty()) {
                            return 'No active days';
                        }
                        
                        // Filter active days based on user role
                        if (auth()->user()->isTeacher()) {
                            // For teachers: only show active days that have questions for their subjects
                            $teacherSubjectIds = auth()->user()->subjects()->pluck('id')->toArray();
                            
                            if (empty($teacherSubjectIds)) {
                                return 'No active days';
                            }
                            
                            $relevantActiveDays = $activeDays->filter(function ($day) use ($teacherSubjectIds) {
                                return $day->questions()->whereIn('subject_id', $teacherSubjectIds)->exists();
                            });
                            
                            if ($relevantActiveDays->isEmpty()) {
                                return 'No active days';
                            }
                            
                            $activeDays = $relevantActiveDays;
                        }
                        
                        // Show up to 2 days, then "and X more"
                        $dayNames = $activeDays->take(2)->map(function ($day) {
                            return $day->title_with_course;
                        })->toArray();
                        
                        if ($activeDays->count() > 2) {
                            $remaining = $activeDays->count() - 2;
                            $dayNames[] = "and {$remaining} more";
                        }
                        
                        return implode(', ', $dayNames);
                    })
                    ->wrap()
                    ->sortable(false),
                Tables\Columns\TextColumn::make('students_count')
                    ->label('Students')
                    ->counts('students')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => static::canEdit($record)),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => static::canDelete($record))
                    ->requiresConfirmation()
                    ->modalHeading('Delete Batch')
                    ->modalDescription(fn ($record) => 
                        'Are you sure you want to delete this batch? ' . 
                        'This will remove ' . $record->students()->count() . 
                        ' student(s) from this batch (they will not be deleted, just unassigned).'
                    )
                    ->modalSubmitActionLabel('Yes, Delete Batch'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Batches')
                        ->modalDescription('Are you sure you want to delete the selected batches? Students in these batches will be unassigned but not deleted.')
                        ->modalSubmitActionLabel('Yes, Delete Batches'),
                ])
                ->visible(fn () => auth()->user()->isAdmin()),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBatches::route('/'),
            'create' => Pages\CreateBatch::route('/create'),
            'edit' => Pages\EditBatch::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        // Admins can edit any batch
        if (auth()->user()->isAdmin()) {
            return true;
        }
        
        // Teachers can only edit their own batches
        if (auth()->user()->isTeacher()) {
            return $record->teacher_id === auth()->id();
        }
        
        return false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        // Only admins can delete batches
        return auth()->user()->isAdmin();
    }
}
