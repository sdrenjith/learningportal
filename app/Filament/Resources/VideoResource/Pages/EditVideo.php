<?php

namespace App\Filament\Resources\VideoResource\Pages;

use App\Filament\Resources\VideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideo extends EditRecord
{
    protected static string $resource = VideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->modalHeading('Video Preview')
                ->modalContent(fn($record) => view('filament.resources.video-resource.preview', ['record' => $record]))
                ->color('info')
                ->modalSubmitActionLabel('Close')
                ->modalCancelAction(false),
        ];
    }
} 