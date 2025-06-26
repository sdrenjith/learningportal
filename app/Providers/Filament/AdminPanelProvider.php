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
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->darkMode(false)
            ->viteTheme('resources/css/filament/admin/theme.css')
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
                Authenticate::class,
                AdminMiddleware::class,
            ])
            ->navigationItems([
                NavigationItem::make('Dashboard')
                    ->icon('heroicon-o-home')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                    ->url(fn (): string => route('filament.admin.pages.dashboard'))
                    ->visible(fn (): bool => auth()->check()),
                NavigationItem::make('Videos')
                    ->icon('heroicon-o-video-camera')
                    ->group('Content Management')
                    ->visible(fn (): bool => auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isDataManager())),
                NavigationItem::make('Notes')
                    ->icon('heroicon-o-document')
                    ->group('Content Management')
                    ->visible(fn (): bool => auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isDataManager()))
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
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Content Management'),
                NavigationGroup::make()
                    ->label('Students'),
            ]);
    }

    public function registerNavigationItems(): void
    {
        // Only show for non-datamanager users
        if (auth()->check() && auth()->user()->isDataManager()) {
            return;
        }
        $courses = \App\Models\Course::with(['days.questions'])->get();
        $items = [];
        // TEST ITEM
        $items[] = \Filament\Navigation\NavigationItem::make('TEST ITEM (should be visible)')
            ->group('Available Courses')
            ->icon('heroicon-o-star')
            ->url('#');
        foreach ($courses as $course) {
            $items[] = \Filament\Navigation\NavigationItem::make($course->name)
                ->group('Available Courses')
                ->icon('heroicon-o-academic-cap')
                ->url(route('filament.admin.resources.courses.edit', ['record' => $course->id]), true);
            foreach ($course->days as $day) {
                $items[] = \Filament\Navigation\NavigationItem::make('— ' . $day->title)
                    ->group('Available Courses')
                    ->icon('heroicon-o-calendar')
                    ->url(route('filament.admin.resources.days.edit', ['record' => $day->id]), true);
                foreach ($day->questions as $question) {
                    $items[] = \Filament\Navigation\NavigationItem::make('—— ' . \Illuminate\Support\Str::limit($question->question_text, 25))
                        ->group('Available Courses')
                        ->icon('heroicon-o-light-bulb')
                        ->url(route('filament.admin.resources.questions.edit', ['record' => $question->id]), true);
                }
            }
        }
        foreach ($items as $item) {
            \Filament\Facades\Filament::registerNavigationItem($item);
        }
    }
}