<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    
    protected static ?string $navigationGroup = 'Content Management';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('topic')
                            ->label('Topic')
                            ->placeholder('Enter the topic covered in this video')
                            ->helperText('Brief description of the main topic or concept covered')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('youtube_url')
                            ->label('YouTube Video URL')
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->helperText('Paste the full YouTube video URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('replace_video')
                            ->label('Upload Video File')
                            ->helperText('Upload a new video to replace the existing one. Leave empty to keep the current video.')
                            ->acceptedFileTypes(['video/mp4', 'video/quicktime', 'video/x-msvideo'])
                            ->maxSize(102400) // 100MB
                            ->columnSpanFull(),
                        Forms\Components\Grid::make(['default' => 1, 'md' => 3])
                            ->schema([
                                Forms\Components\Select::make('course_id')
                                    ->label('Course')
                                    ->relationship('course', 'name')
                                    ->required()
                                    ->placeholder('Select course')
                                    ->preload(),
                                Forms\Components\Select::make('subject_id')
                                    ->label('Subject')
                                    ->relationship('subject', 'name')
                                    ->required()
                                    ->placeholder('Select subject')
                                    ->preload(),
                                Forms\Components\TextInput::make('day_number')
                                    ->label('Day')
                                    ->required()
                                    ->numeric()
                                    ->default(1),
                            ]),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('topic')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('course.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('day_number')
                    ->label('Day')
                    ->formatStateUsing(fn($state) => 'Day ' . $state)
                    ->sortable(),
                Tables\Columns\TextColumn::make('video_type')
                    ->label('Type')
                    ->formatStateUsing(function ($record) {
                        if ($record->youtube_url) {
                            return 'YouTube';
                        } elseif ($record->video_path) {
                            return 'File';
                        }
                        return 'None';
                    })
                    ->badge()
                    ->color(fn ($record) => 
                        $record->youtube_url ? 'danger' : 
                        ($record->video_path ? 'success' : 'gray')
                    ),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('course')
                    ->relationship('course', 'name'),
                Tables\Filters\SelectFilter::make('subject')
                    ->relationship('subject', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Video Preview')
                    ->modalContent(fn($record) => view('filament.resources.video-resource.preview', ['record' => $record]))
                    ->color('info')
                    ->modalSubmitActionLabel('Go Back')
                    ->modalCancelAction(false),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
} 