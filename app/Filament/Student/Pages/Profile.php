<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;

class Profile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static string $view = 'filament.student.pages.profile';
    protected static ?string $title = 'My Profile';
    protected static ?string $navigationLabel = 'My Profile';
    protected static ?string $slug = 'profile';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
} 