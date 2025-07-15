<?php

namespace App\Filament\Resources\VideoResource\Pages;

use App\Filament\Resources\VideoResource;
use App\Helpers\VideoHelper;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Debug logging
        \Log::info('CreateVideo - Raw form data:', $data);
        
        // Handle file upload
        if (!empty($data['replace_video'])) {
            $data['video_path'] = $data['replace_video'];
            // Clear YouTube URL if file is uploaded
            $data['youtube_url'] = null;
            \Log::info('CreateVideo - File uploaded, setting video_path:', ['video_path' => $data['video_path']]);
        }

        // Handle YouTube URL - simplified logic
        if (!empty($data['youtube_url'])) {
            \Log::info('CreateVideo - YouTube URL found:', ['youtube_url' => $data['youtube_url']]);
            // Clear video_path if YouTube URL is provided
            $data['video_path'] = null;
            \Log::info('CreateVideo - YouTube URL set, clearing video_path');
        } else {
            \Log::info('CreateVideo - No YouTube URL provided');
        }

        // Remove the replace_video field as it's not a database column
        unset($data['replace_video']);
        
        \Log::info('CreateVideo - Final data to save:', $data);

        return $data;
    }

    protected function afterCreate(): void
    {
        // Debug logging after creation
        \Log::info('CreateVideo - Record created:', $this->record->toArray());
    }
} 