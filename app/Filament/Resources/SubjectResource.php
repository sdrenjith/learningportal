<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Filament\Resources\SubjectResource\RelationManagers;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Subject Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('teacher_id')
                            ->label('Assigned Teacher')
                            ->options(fn () => \App\Models\User::where('role', 'teacher')->pluck('name', 'id')->toArray())
                            ->placeholder('Select a teacher')
                            ->helperText('Choose a teacher to assign to this subject')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Subject Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Assigned Teacher')
                    ->sortable()
                    ->searchable()
                    ->placeholder('No teacher assigned')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('teacher_id')
                    ->label('Filter by Teacher')
                    ->relationship('teacher', 'name', fn (Builder $query) => $query->where('role', 'teacher'))
                    ->placeholder('All teachers'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }

    public static function getNavigationSort(): ?int
    {
        return 4;
    }

    public static function shouldRegisterNavigation(): bool
    {
        // Show for admin only
        return auth()->check() && auth()->user()->isAdmin();
    }

    public static function canCreate(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }
}
