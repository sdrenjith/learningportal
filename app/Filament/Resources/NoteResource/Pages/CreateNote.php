<?php

namespace App\Filament\Resources\NoteResource\Pages;

use App\Filament\Resources\NoteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNote extends CreateRecord
{
    protected static string $resource = NoteResource::class;
    public static bool $createAnother = false;

    protected function getFormActions(): array
    {
        return array_filter(parent::getFormActions(), function ($action) {
            return $action->getName() !== 'createAnother';
        });
    }
} 