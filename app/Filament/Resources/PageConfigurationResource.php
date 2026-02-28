<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageConfigurationResource\Pages;
use App\Models\PageConfiguration;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Unique;

class PageConfigurationResource extends Resource
{
    protected static ?string $model = PageConfiguration::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?string $navigationLabel = 'Page Configurations';

    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        Select::make('page_name')
                            ->label('Page Name')
                            ->options([
                                'welcome' => 'Welcome Page',
                                'dashboard' => 'Dashboard',
                                'about' => 'About Page',
                                'contact' => 'Contact Page',
                            ])
                            ->required()
                            ->live() // Triggers a UI refresh when changed
                            ->searchable(),

                        Select::make('section_key')
                            ->label('Section Key')
                            ->required()
                            ->live() // Triggers a UI refresh for the content fields below
                            ->unique(
                                ignoreRecord: true,
                                modifyRuleUsing: fn(Unique $rule, Get $get) => $rule->where('page_name', $get('page_name')),
                            )
                            ->options(fn(Get $get): array => match ($get('page_name')) {
                                'welcome' => [
                                    'hero' => 'Hero',
                                    'features' => 'Features',
                                    'stats' => 'Statistics',
                                ],
                                'dashboard' => [
                                    'hero' => 'Hero',
                                    'platforms' => 'Platforms',
                                    'about' => 'About',
                                    'features' => 'Features',
                                    'certifications' => 'Certifications',
                                ],
                                default => [
                                    'hero' => 'Hero',
                                    'content' => 'Main Content',
                                ],
                            })
                            ->helperText('Select the section to configure its specific fields.'),

                        TextInput::make('order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Content Configuration')
                    ->schema([
                        Forms\Components\Hidden::make('content')
                            ->dehydrateStateUsing(fn($state) => \is_string($state) ? json_decode($state, true) : $state),
                    ]),

                Section::make('Visual Content Editor')
                    ->description('Fields dynamically display based on the selected Page and Section Key.')
                    ->schema([
                        // --- STANDARD TEXT FIELDS ---

                        TextInput::make('content.title')
                            ->label('Title')
                            ->maxLength(255)
                            ->visible(fn(Get $get) => \in_array($get('section_key'), ['hero', 'features', 'stats', 'platforms', 'about', 'certifications'])),

                        TextInput::make('content.subtitle')
                            ->label('Subtitle')
                            ->maxLength(255)
                            ->visible(
                                fn(Get $get) =>
                                ($get('page_name') === 'welcome' && \in_array($get('section_key'), ['hero', 'features'])) ||
                                ($get('page_name') === 'dashboard' && $get('section_key') === 'hero'),
                            ),

                        TextInput::make('content.heading')
                            ->label('Heading')
                            ->maxLength(255)
                            ->visible(fn(Get $get) => $get('page_name') === 'dashboard' && \in_array($get('section_key'), ['platforms', 'certifications'])),

                        Forms\Components\Textarea::make('content.description')
                            ->label('Description')
                            ->rows(3)
                            ->visible(
                                fn(Get $get) =>
                                ($get('page_name') === 'welcome' && $get('section_key') === 'hero') ||
                                ($get('page_name') === 'dashboard' && \in_array($get('section_key'), ['platforms', 'about', 'features', 'certifications'])),
                            ),

                        // --- CALL TO ACTIONS & BUTTONS ---

                        TextInput::make('content.cta_primary')
                            ->label('Primary CTA Button Text')
                            ->maxLength(100)
                            ->visible(fn(Get $get) => \in_array($get('section_key'), ['hero', 'platforms']) && \in_array($get('page_name'), ['welcome', 'dashboard'])),

                        TextInput::make('content.cta_secondary')
                            ->label('Secondary CTA Button Text')
                            ->maxLength(100)
                            ->visible(fn(Get $get) => \in_array($get('section_key'), ['hero', 'platforms']) && \in_array($get('page_name'), ['welcome', 'dashboard'])),

                        TextInput::make('content.button_text')
                            ->label('Button Text')
                            ->maxLength(100)
                            ->visible(fn(Get $get) => $get('page_name') === 'dashboard' && \in_array($get('section_key'), ['about', 'features', 'certifications'])),

                        // --- MEDIA & ANIMATION ---

                        TextInput::make('content.image')
                            ->label('Image URL')
                            ->maxLength(255)
                            ->visible(fn(Get $get) => $get('page_name') === 'dashboard' && \in_array($get('section_key'), ['about', 'features'])),

                        TextInput::make('content.background_image')
                            ->label('Background Image URL')
                            ->maxLength(255)
                            ->visible(fn(Get $get) => $get('page_name') === 'dashboard' && \in_array($get('section_key'), ['about', 'features'])),

                        TextInput::make('content.animation')
                            ->label('Animation Class')
                            ->maxLength(100)
                            ->visible(fn(Get $get) => $get('page_name') === 'dashboard' && \in_array($get('section_key'), ['about', 'features'])),

                        Toggle::make('content.show_carousel')
                            ->label('Show Carousel')
                            ->visible(fn(Get $get) => $get('page_name') === 'dashboard' && $get('section_key') === 'hero'),

                        // --- REPEATERS / ARRAYS ---

                        Repeater::make('content.carousel_images')
                            ->label('Carousel Images')
                            ->simple(TextInput::make('image_url')->label('Image URL')->required())
                            ->columnSpanFull()
                            ->visible(fn(Get $get) => $get('page_name') === 'dashboard' && $get('section_key') === 'hero'),

                        Repeater::make('content.complex_features')
                            ->label('Features')
                            ->schema([
                                TextInput::make('icon')->label('Icon Name')->maxLength(100),
                                TextInput::make('title')->label('Feature Title')->required()->maxLength(255),
                                Forms\Components\Textarea::make('description')->label('Feature Description')->rows(2),
                            ])
                            ->collapsible()
                            ->columnSpanFull()
                            ->visible(fn(Get $get) => $get('page_name') === 'welcome' && \in_array($get('section_key'), ['features'])),

                        Repeater::make('content.features')
                            ->label('Features')
                            ->simple(TextInput::make('feature')->label('Feature')->required())
                            ->columnSpanFull()
                            ->visible(fn(Get $get) => $get('page_name') === 'dashboard' && $get('section_key') === 'features'),

                        Repeater::make('content.stats')
                            ->label('Statistics')
                            ->schema([
                                TextInput::make('value')->label('Stat Value')->required()->maxLength(50),
                                TextInput::make('label')->label('Stat Label')->required()->maxLength(100),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->visible(fn(Get $get) => $get('page_name') === 'welcome' && $get('section_key') === 'stats'),

                        Repeater::make('content.platforms')
                            ->label('Platforms')
                            ->schema([
                                TextInput::make('name')->label('Platform Name')->required()->maxLength(255),
                                TextInput::make('image')->label('Image URL')->maxLength(255),
                                Forms\Components\Textarea::make('description')->label('Description')->rows(2),
                            ])
                            ->collapsible()
                            ->columnSpanFull()
                            ->visible(fn(Get $get) => $get('page_name') === 'dashboard' && $get('section_key') === 'platforms'),

                        Repeater::make('content.highlights')
                            ->label('Highlights')
                            ->simple(TextInput::make('highlight')->label('Highlight')->required())
                            ->columnSpanFull()
                            ->visible(fn(Get $get) => $get('page_name') === 'dashboard' && $get('section_key') === 'about'),

                        Repeater::make('content.certificates')
                            ->label('Certificates')
                            ->schema([
                                TextInput::make('title')->label('Certificate Title')->required()->maxLength(255),
                                Forms\Components\Textarea::make('description')->label('Description')->rows(2),
                                TextInput::make('image')->label('Image URL')->maxLength(255),
                                Repeater::make('tags')
                                    ->label('Tags')
                                    ->simple(TextInput::make('tag')->label('Tag'))
                                    ->columns(1),
                            ])
                            ->collapsible()
                            ->columnSpanFull()
                            ->visible(fn(Get $get) => $get('page_name') === 'dashboard' && $get('section_key') === 'certifications'),
                    ])
                    ->columns(2),

                // Optional: Keep the Raw JSON preview at the bottom if admins still want to verify it
                Section::make('Raw Content (JSON Preview)')
                    ->schema([
                        Forms\Components\Textarea::make('content_preview')
                            ->label('Data Structure')
                            ->rows(6)
                            ->columnSpanFull()
                            ->formatStateUsing(fn($record) => $record ? json_encode($record->content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '')
                            ->dehydrated(false)
                            ->disabled(),
                    ])->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('page_name')
                    ->label('Page')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'welcome' => 'success',
                        'dashboard' => 'info',
                        'about' => 'warning',
                        'contact' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('section_key')
                    ->label('Section')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('order')
                    ->label('Order')
                    ->sortable()
                    ->alignCenter(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('page_name')
                    ->label('Page')
                    ->options([
                        'welcome' => 'Welcome Page',
                        'dashboard' => 'Dashboard',
                        'about' => 'About Page',
                        'contact' => 'Contact Page',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('page_name', 'asc')
            ->defaultSort('order', 'asc');
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
            'index' => Pages\ListPageConfigurations::route('/'),
            'create' => Pages\CreatePageConfiguration::route('/create'),
            'edit' => Pages\EditPageConfiguration::route('/{record}/edit'),
        ];
    }
}
