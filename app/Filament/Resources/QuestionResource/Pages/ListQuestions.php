<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Filament\Resources\QuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuestions extends ListRecords
{
    protected static string $resource = QuestionResource::class;

    public function getTitle(): string
    {
        return 'Questions';
    }

    public function getSubheading(): ?string
    {
        return 'Manage and organize your assessment questions effectively.';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Question')
                ->icon('heroicon-m-plus')
                ->color('primary')
                ->size('lg'),
        ];
    }

    // Custom breadcrumbs
    public function getBreadcrumbs(): array
    {
        return [
            '' => 'Questions',
        ];
    }
}