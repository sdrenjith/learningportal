<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;

class SpeakingSessions extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-microphone';
    protected static string $view = 'filament.student.pages.speaking-sessions';
    protected static ?string $title = 'Speaking Sessions';
    protected static ?string $navigationLabel = 'Speaking Sessions';
    protected static ?string $slug = 'speaking-sessions';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
} 