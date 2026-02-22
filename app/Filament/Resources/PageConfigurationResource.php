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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageConfigurationResource extends Resource
{
    protected static ?string $model = PageConfiguration::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?string $navigationLabel = 'Page Configurations';

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
                            ->searchable(),

                        TextInput::make('section_key')
                            ->label('Section Key')
                            ->required()
                            ->helperText('Unique identifier for this section (e.g., hero, features, stats)')
                            ->maxLength(255),

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
                        Forms\Components\Textarea::make('content_preview')
                            ->label('Content (JSON)')
                            ->helperText('Edit the JSON content below. Use the visual editor for common fields.')
                            ->rows(10)
                            ->columnSpanFull()
                            ->formatStateUsing(fn($record) => $record ? json_encode($record->content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '')
                            ->dehydrated(false)
                            ->disabled(),

                        Forms\Components\Hidden::make('content')
                            ->dehydrateStateUsing(fn($state) => \is_string($state) ? json_decode($state, true) : $state),
                    ]),

                Section::make('Visual Content Editor')
                    ->description('Common fields for easy editing. Advanced users can edit JSON directly.')
                    ->schema([
                        TextInput::make('content.title')
                            ->label('Title')
                            ->maxLength(255),

                        TextInput::make('content.subtitle')
                            ->label('Subtitle')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('content.description')
                            ->label('Description')
                            ->rows(3),

                        TextInput::make('content.heading')
                            ->label('Heading')
                            ->maxLength(255),

                        TextInput::make('content.cta_primary')
                            ->label('Primary CTA Button Text')
                            ->maxLength(100),

                        TextInput::make('content.cta_secondary')
                            ->label('Secondary CTA Button Text')
                            ->maxLength(100),

                        TextInput::make('content.button_text')
                            ->label('Button Text')
                            ->maxLength(100),

                        TextInput::make('content.image')
                            ->label('Image URL')
                            ->maxLength(255),

                        TextInput::make('content.background_image')
                            ->label('Background Image URL')
                            ->maxLength(255),

                        Toggle::make('content.show_carousel')
                            ->label('Show Carousel'),

                        Repeater::make('content.features')
                            ->label('Features List')
                            ->schema([
                                TextInput::make('icon')
                                    ->label('Icon Name')
                                    ->maxLength(100),
                                TextInput::make('title')
                                    ->label('Feature Title')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->label('Feature Description')
                                    ->rows(2),
                            ])
                            ->collapsible()
                            ->columnSpanFull(),

                        Repeater::make('content.stats')
                            ->label('Statistics')
                            ->schema([
                                TextInput::make('value')
                                    ->label('Stat Value')
                                    ->required()
                                    ->maxLength(50),
                                TextInput::make('label')
                                    ->label('Stat Label')
                                    ->required()
                                    ->maxLength(100),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        Repeater::make('content.platforms')
                            ->label('Platforms')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Platform Name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('image')
                                    ->label('Image URL')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->label('Description')
                                    ->rows(2),
                            ])
                            ->collapsible()
                            ->columnSpanFull(),

                        Repeater::make('content.highlights')
                            ->label('Highlights')
                            ->simple(
                                TextInput::make('highlight')
                                    ->label('Highlight')
                                    ->required(),
                            )
                            ->columnSpanFull(),

                        Repeater::make('content.carousel_images')
                            ->label('Carousel Images')
                            ->simple(
                                TextInput::make('image_url')
                                    ->label('Image URL')
                                    ->required(),
                            )
                            ->columnSpanFull(),

                        Repeater::make('content.certificates')
                            ->label('Certificates')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Certificate Title')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->label('Description')
                                    ->rows(2),
                                TextInput::make('image')
                                    ->label('Image URL')
                                    ->maxLength(255),
                                Repeater::make('tags')
                                    ->label('Tags')
                                    ->simple(
                                        TextInput::make('tag')
                                            ->label('Tag'),
                                    )
                                    ->columns(1),
                            ])
                            ->collapsible()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
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
