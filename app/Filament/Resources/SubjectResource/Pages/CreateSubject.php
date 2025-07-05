<?php

namespace App\Filament\Resources\SubjectResource\Pages;

use App\Filament\Resources\SubjectResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSubject extends CreateRecord
{
    protected static string $resource = SubjectResource::class;

    protected function getFormActions(): array
    {
        $actions = parent::getFormActions();
        return array_filter($actions, function ($action) {
            return $action->getName() !== 'createAnother';
        });
    }
}
