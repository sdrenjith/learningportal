<?php

namespace App\Filament\Resources\VideoResource\Pages;

use App\Filament\Resources\VideoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVideo extends CreateRecord
{
    protected static string $resource = VideoResource::class;
    public static bool $createAnother = false;

    protected function getFormActions(): array
    {
        return array_filter(parent::getFormActions(), function ($action) {
            return $action->getName() !== 'createAnother';
        });
    }
} 