<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use App\Models\Course;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Illuminate\Support\Str;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Vite;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\StudentMiddleware;
use Filament\Facades\Filament;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->darkMode(false)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->assets([
                Css::make('custom-checkbox-fix', 'resources/css/filament/admin/custom.css'),
            ])
            ->brandName('Practice Platform')
            ->brandLogo(asset('images/logo.png'))
            ->favicon(asset('images/favicon.ico'))
            ->spa()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->resources([
                \App\Filament\Resources\CourseResource::class,
                \App\Filament\Resources\BatchResource::class,
                \App\Filament\Resources\StudentResource::class,
                \App\Filament\Resources\NoteResource::class,
                \App\Filament\Resources\VideoResource::class,
                \App\Filament\Resources\UserResource::class,
                \App\Filament\Resources\SubjectResource::class,
                \App\Filament\Resources\QuestionResource::class,
                \App\Filament\Resources\QuestionMediaResource::class,
                \App\Filament\Resources\OptionResource::class,
                \App\Filament\Resources\DayResource::class,
                \App\Filament\Resources\OpinionVerificationResource::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                AdminMiddleware::class,
            ])
            ->navigationItems(array_merge([
                NavigationItem::make('Dashboard')
                    ->icon('heroicon-o-home')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                    ->url(fn (): string => route('filament.admin.pages.dashboard'))
                    ->visible(fn (): bool => auth()->check()),
                NavigationItem::make('Videos')
                    ->icon('heroicon-o-video-camera')
                    ->group('Content Management')
                    ->visible(fn (): bool => auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isDataManager() || auth()->user()->isTeacher())),
                NavigationItem::make('Notes')
                    ->icon('heroicon-o-document')
                    ->group('Content Management')
                    ->visible(fn (): bool => auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isDataManager() || auth()->user()->isTeacher()))
                    ->url(fn (): string => route('filament.admin.resources.notes.index')),
                NavigationItem::make('Register Student')
                    ->icon('heroicon-o-user-plus')
                    ->group('Students')
                    ->url(fn (): string => route('filament.admin.resources.students.create'))
                    ->visible(fn (): bool => auth()->user()->isAdmin()),
                NavigationItem::make('All Students')
                    ->icon('heroicon-o-users')
                    ->group('Students')
                    ->url(fn (): string => route('filament.admin.resources.students.index'))
                    ->visible(fn (): bool => auth()->user()->isAdmin()),
            ], $this->getCourseNavigationItems()))
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Content Management'),
                NavigationGroup::make()
                    ->label('Students'),
                NavigationGroup::make()
                    ->label('A1 Course')
                    ->collapsible(),
                NavigationGroup::make()
                    ->label('A2 Course')
                    ->collapsible(),
                NavigationGroup::make()
                    ->label('B1 Course')
                    ->collapsible(),
                NavigationGroup::make()
                    ->label('B2 Course')
                    ->collapsible(),
            ]);
    }

    protected function getCourseNavigationItems(): array
    {
        // Only show for non-datamanager users
        if (auth()->check() && auth()->user()->isDataManager()) {
            return [];
        }
        
        try {
            $courses = \App\Models\Course::all();
            // Filter subjects based on user role
            if (auth()->check() && auth()->user()->isTeacher()) {
                $subjects = auth()->user()->subjects;
            } else {
                $subjects = \App\Models\Subject::all();
            }
            $questions = \App\Models\Question::all()->groupBy(function($q) {
                return $q->course_id . '-' . $q->subject_id . '-' . $q->day_id;
            });
            $days = \App\Models\Day::all()->keyBy('id');
            
            $items = [];
            
            foreach ($courses as $course) {
                $courseGroupName = $course->name . ' Course';
                
                // Add all subjects under each course
                foreach ($subjects as $subject) {
                    // Check if this subject has any questions for this course
                    $hasQuestions = false;
                    $subjectDays = collect();
                    
                    foreach ($questions as $key => $questionGroup) {
                        list($courseId, $subjectId, $dayId) = explode('-', $key);
                        if ($courseId == $course->id && $subjectId == $subject->id && isset($days[$dayId])) {
                            $hasQuestions = true;
                            $subjectDays->put($dayId, $days[$dayId]);
                        }
                    }
                    
                    if ($hasQuestions) {
                        $items[] = \Filament\Navigation\NavigationItem::make($subject->name)
                            ->group($courseGroupName)
                            ->icon('heroicon-o-rectangle-stack')
                            ->url('#')
                            ->isActiveWhen(fn () => false)
                            ->badge(function() use ($course, $subject, $questions) {
                                $count = 0;
                                foreach ($questions as $key => $questionGroup) {
                                    list($courseId, $subjectId, $dayId) = explode('-', $key);
                                    if ($courseId == $course->id && $subjectId == $subject->id) {
                                        $count += $questionGroup->count();
                                    }
                                }
                                return $count;
                            })
                            ->badgeColor('success')
                            ->sort($subject->id);
                        
                        // Add days under subject
                        foreach ($subjectDays as $day) {
                            $dayQuestions = $questions->get($course->id . '-' . $subject->id . '-' . $day->id, collect());
                            
                            $items[] = \Filament\Navigation\NavigationItem::make('→ ' . $day->title)
                                ->group($courseGroupName)
                                ->icon('heroicon-o-calendar')
                                ->url('#')
                                ->isActiveWhen(fn () => false)
                                ->badge($dayQuestions->count())
                                ->badgeColor('warning')
                                ->sort(100 + $subject->id * 10 + $day->id);
                        }
                    }
                }
            }
            
            return $items;
        } catch (\Exception $e) {
            // Return empty array if there's any error
            return [];
        }
    }
}