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
use Illuminate\Support\Str;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->darkMode(false)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->brandName('Practice Platform')
            ->brandLogo(asset('images/logo.png'))
            ->favicon(asset('images/favicon.ico'))
            ->spa()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
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
            ]);
    }

    public function registerNavigationItems(): void
    {
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
