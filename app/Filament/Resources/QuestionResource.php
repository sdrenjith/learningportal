<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;
    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Single comprehensive section
                Forms\Components\Section::make('Create Question')
                    ->description('Fill in all the details to create a new question')
                    ->icon('heroicon-m-plus-circle')
                    ->schema([
                        // Basic question info
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\Select::make('day_id')
                                    ->label('Day')
                                    ->relationship('day', 'title')
                                    ->required()
                                    ->placeholder('Select day')
                                    ->searchable()
                                    ->preload(),

                                Forms\Components\Select::make('level_id')
                                    ->label('Level')
                                    ->relationship('level', 'name')
                                    ->required()
                                    ->placeholder('Select level')
                                    ->searchable()
                                    ->preload(),

                                Forms\Components\Select::make('subject_id')
                                    ->label('Subject')
                                    ->relationship('subject', 'name')
                                    ->required()
                                    ->placeholder('Select subject')
                                    ->searchable()
                                    ->preload(),

                                Forms\Components\Select::make('question_type_id')
                                    ->label('Question Type')
                                    ->relationship('questionType', 'name')
                                    ->required()
                                    ->placeholder('Select type')
                                    ->searchable()
                                    ->preload(),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('points')
                                    ->label('Points')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->placeholder('Points (default: 1)'),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),
                            ]),

                        // Question content
                        Forms\Components\Textarea::make('instruction')
                            ->label('Question Instruction')
                            ->required()
                            ->placeholder('Enter the question instruction...')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('explanation')
                            ->label('Explanation (Optional)')
                            ->placeholder('Enter explanation if needed...')
                            ->rows(2)
                            ->columnSpanFull(),

                        // Options Section
                        Forms\Components\Fieldset::make('Question Options')
                            ->schema([
                                Forms\Components\Repeater::make('question_options')
                                    ->label('')
                                    ->schema([
                                        Forms\Components\TextInput::make('option')
                                            ->label('Option Text')
                                            ->required()
                                            ->placeholder('Enter option text...')
                                            ->maxLength(500)
                                            ->extraAttributes(['class' => 'option-input']),
                                    ])
                                    ->default(function ($record) {
                                        if ($record && $record->question_data) {
                                            $data = json_decode($record->question_data, true);
                                            if (isset($data['options'])) {
                                                return collect($data['options'])->map(fn($opt) => ['option' => $opt])->toArray();
                                            }
                                        }
                                        // Start with only one option field
                                        return [['option' => '']];
                                    })
                                    ->addActionLabel('+ Add Option')
                                    ->deleteAction(
                                        fn ($action) => $action
                                            ->label('Remove')
                                            ->size('sm')
                                            ->color('danger')
                                            ->icon('heroicon-m-trash')
                                            ->extraAttributes(['class' => 'remove-btn-red'])
                                    )
                                    ->addAction(
                                        fn ($action) => $action
                                            ->label('+ Add Option')
                                            ->size('sm')
                                            ->color('success')
                                            ->icon('heroicon-m-plus')
                                            ->extraAttributes(['class' => 'add-btn-green'])
                                    )
                                    ->minItems(1) // Allow minimum 1 option
                                    ->maxItems(10)
                                    ->columnSpanFull()
                                    ->collapsed(false)
                                    ->reorderableWithButtons()
                                    ->itemLabel(fn (array $state): ?string => 'Option: ' . ($state['option'] ?? 'New Option')),
                            ])
                            ->columnSpanFull(),

                        // Answer Indices Section
                        Forms\Components\Fieldset::make('Correct Answer Indices')
                            ->schema([
                                Forms\Components\Placeholder::make('indices_help')
                                    ->label('')
                                    ->content('**Note:** Use 0 for first option, 1 for second option, 2 for third option, etc.')
                                    ->columnSpanFull(),

                                Forms\Components\Repeater::make('correct_indices')
                                    ->label('')
                                    ->schema([
                                        Forms\Components\TextInput::make('index')
                                            ->label('Answer Index')
                                            ->numeric()
                                            ->required()
                                            ->placeholder('0')
                                            ->minValue(0)
                                            ->extraAttributes(['class' => 'index-input'])
                                            ->helperText('Enter the index of the correct option'),
                                    ])
                                    ->default(function ($record) {
                                        if ($record && $record->answer_data) {
                                            $data = json_decode($record->answer_data, true);
                                            if (isset($data['correct_indices'])) {
                                                return collect($data['correct_indices'])->map(fn($idx) => ['index' => $idx])->toArray();
                                            }
                                        }
                                        return [['index' => 0]];
                                    })
                                    ->addActionLabel('+ Add Answer Index')
                                    ->deleteAction(
                                        fn ($action) => $action
                                            ->label('Remove')
                                            ->size('sm')
                                            ->color('danger')
                                            ->icon('heroicon-m-trash')
                                            ->extraAttributes(['class' => 'remove-btn-red'])
                                    )
                                    ->addAction(
                                        fn ($action) => $action
                                            ->label('+ Add Answer Index')
                                            ->size('sm')
                                            ->color('primary')
                                            ->icon('heroicon-m-plus')
                                    )
                                    ->minItems(1)
                                    ->columnSpanFull()
                                    ->collapsed(false)
                                    ->reorderableWithButtons()
                                    ->itemLabel(fn (array $state): ?string => 'Answer Index: ' . ($state['index'] ?? 'New')),
                            ])
                            ->columnSpanFull(),

                        // Hidden fields for JSON data
                        Forms\Components\Hidden::make('question_data')
                            ->dehydrateStateUsing(function ($state, $get) {
                                $options = collect($get('question_options'))->pluck('option')->filter()->toArray();
                                return json_encode([
                                    'question' => $get('instruction') ?: 'Auto-generated question from form',
                                    'options' => $options,
                                ]);
                            }),

                        Forms\Components\Hidden::make('answer_data')
                            ->dehydrateStateUsing(function ($state, $get) {
                                $indices = collect($get('correct_indices'))->pluck('index')->map(fn($i) => (int)$i)->filter()->toArray();
                                return json_encode([
                                    'correct_indices' => $indices,
                                ]);
                            }),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('instruction')
                    ->label('Question')
                    ->searchable()
                    ->extraAttributes(['style' => 'max-width: 600px; min-width: 350px; white-space: normal; word-break: break-word; font-size: 1rem;']),

                Tables\Columns\TextColumn::make('day.title')
                    ->label('Day'),

                Tables\Columns\TextColumn::make('day.course.name')
                    ->label('Course')
                    ->badge()
                    ->color('secondary'),

                Tables\Columns\TextColumn::make('subject.name')
                    ->label('Subject'),

                Tables\Columns\TextColumn::make('questionType.name')
                    ->label('Type'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level_id')
                    ->relationship('level', 'name'),
                Tables\Filters\SelectFilter::make('subject_id')
                    ->relationship('subject', 'name'),
            ])
            ->actions([
                \Filament\Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => static::getUrl('view', ['record' => $record])),
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(fn ($record) => static::getUrl('view', ['record' => $record]));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
            'view' => Pages\ViewQuestion::route('/{record}'),
        ];
    }

    public static function getNavigationSort(): ?int
    {
        return 5;
    }
}