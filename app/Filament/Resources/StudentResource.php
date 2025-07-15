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
                Section::make('Profile Details')
                    ->schema([
                        Grid::make(1)->schema([
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
                                    }
                                }),
                            TextInput::make('age')
                                ->label('Age')
                                ->numeric()
                                ->required()
                                ->minValue(1)
                                ->maxValue(120)
                                ->helperText('Age will be auto-calculated from Date of Birth, but you can manually override it here'),
                            TextInput::make('phone')
                                ->tel()
                                ->required(),
                            TextInput::make('father_whatsapp')
                                ->label("Father's WhatsApp")
                                ->tel()
                                ->required(),
                            TextInput::make('mother_whatsapp')
                                ->label("Mother's WhatsApp")
                                ->tel()
                                ->required(),
                            \Filament\Forms\Components\ViewField::make('gender')
                                ->view('forms.components.gender-select'),
                            TextInput::make('nationality')
                                ->required()
                                ->default('Indian'),
                            \Filament\Forms\Components\ViewField::make('category')
                                ->view('forms.components.category-select'),
                            \Filament\Forms\Components\ViewField::make('qualification')
                                ->view('forms.components.qualification-select'),
                            TextInput::make('experience_months')
                                ->label('Experience in Months')
                                ->numeric()
                                ->minValue(0)
                                ->required(),
                            TextInput::make('passport_number')
                                ->label('Passport Number')
                                ->required(),
                            \Filament\Forms\Components\ViewField::make('batch_id')
                                ->label('Batch')
                                ->view('forms.components.batch-select'),
                        ])
                    ]),
                Section::make('Address Information')
                    ->schema([
                        Grid::make(1)->schema([
                            \Filament\Forms\Components\Textarea::make('address')
                                ->label('Address')
                                ->required()
                                ->rows(3),
                        ])
                    ]),
                Section::make('Financial Information')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('course_fee')
                                ->label('Course Fee')
                                ->numeric()
                                ->prefix('₹')
                                ->required(),
                            TextInput::make('fees_paid')
                                ->label('Fees Paid')
                                ->numeric()
                                ->prefix('₹')
                                ->required(),
                            TextInput::make('balance_fees_due')
                                ->label('Balance Fees Due')
                                ->numeric()
                                ->prefix('₹')
                                ->required(),
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
                    ->label('Batch')
                    ->sortable(),
                Tables\Columns\TextColumn::make('qualification')
                    ->sortable(),
                Tables\Columns\TextColumn::make('course_fee')
                    ->label('Course Fee')
                    ->money('INR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fees_paid')
                    ->label('Fees Paid')
                    ->money('INR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('balance_fees_due')
                    ->label('Balance Due')
                    ->money('INR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
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