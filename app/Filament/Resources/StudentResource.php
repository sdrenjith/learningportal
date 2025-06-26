<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Batch;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class StudentResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'students';

    protected static ?string $modelLabel = 'Student';

    protected static ?string $pluralModelLabel = 'Students';

    protected static bool $shouldRegisterNavigation = false;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'student');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Course Details')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('course_fee')
                                ->label('Course Fee')
                                ->numeric()
                                ->prefix('₹')
                                ->required(),
                            FileUpload::make('profile_picture')
                                ->label('Profile Picture')
                                ->image()
                                ->directory('profile-pictures')
                                ->imageEditor(),
                        ]),
                    ]),
                Section::make('Personal Information')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Full Name')
                                ->required(),
                            TextInput::make('father_name')
                                ->label("Father's Name")
                                ->required(),
                            TextInput::make('mother_name')
                                ->label("Mother's Name")
                                ->required(),
                            DatePicker::make('dob')
                                ->label('Date of Birth')
                                ->id('dob-datepicker')
                                ->native(false)
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function (Set $set, $state) {
                                    if ($state) {
                                        $set('age', Carbon::parse($state)->age);
                                    } else {
                                        $set('age', null);
                                    }
                                }),
                            TextInput::make('age')
                                ->label('Age')
                                ->numeric()
                                ->readOnly()
                                ->required(),
                            TextInput::make('phone')
                                ->tel()
                                ->required(),
                            \Filament\Forms\Components\ViewField::make('gender')
                                ->view('forms.components.gender-select'),
                            TextInput::make('nationality')
                                ->required()
                                ->default('Indian'),
                            \Filament\Forms\Components\ViewField::make('category')
                                ->view('forms.components.category-select'),
                            \Filament\Forms\Components\ViewField::make('batch_id')
                                ->label('Batch')
                                ->view('forms.components.batch-select'),
                        ])
                    ]),
                Section::make('Login Credentials')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('username')
                                ->required()
                                ->unique(table: User::class, ignoreRecord: true),
                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->unique(table: User::class, ignoreRecord: true),
                            TextInput::make('password')
                                ->password()
                                ->required(fn (string $context): bool => $context === 'create')
                                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                ->dehydrated(fn ($state) => filled($state))
                                ->revealable(),
                            TextInput::make('password_confirmation')
                                ->password()
                                ->required(fn (string $context): bool => $context === 'create')
                                ->same('password')
                                ->dehydrated(false)
                                ->revealable(),
                        ])
                    ]),
                Section::make('Documents')
                    ->schema([
                        FileUpload::make('attachments')
                            ->multiple()
                            ->directory('student-attachments')
                            ->preserveFilenames()
                            ->maxSize(10240)
                            ->helperText('Upload resumes, certificates, etc. (max 10MB)'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Full Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('batch.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
} 