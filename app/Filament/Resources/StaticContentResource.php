<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaticContentResource\Pages;
use App\Models\StaticContent;
use App\Services\AdminContentExporter;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class StaticContentResource extends Resource
{
    protected static ?string $model = StaticContent::class;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-newspaper';

    protected static string|null|\UnitEnum $navigationGroup = 'Content';

    public static function form(Form|\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form->schema([
            Fieldset::make('Static Content')
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => filled($state) ? $set('slug', Str::slug($state)) : null),
                    TextInput::make('slug')
                        ->disabled()
                        ->dehydrated()
                        ->required(),
                    RichEditor::make('content')
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'strike',
                            'underline',
                            'bulletList',
                            'orderedList',
                            'link',
                            'blockquote',
                            'codeBlock',
                        ])
                        ->required(),
                    TextInput::make('type')
                        ->default('common')
                        ->required(),
                    Textarea::make('value')
                        ->default('{}')
                        ->rows(4)
                        ->columnSpanFull(),
                    Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'publish' => 'Publish',
                        ])
                        ->required(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('type')->searchable(),
                TextColumn::make('status')->badge()->colors([
                    'warning' => 'pending',
                    'success' => 'publish',
                ]),
                TextColumn::make('created_at')->dateTime('Y-m-d H:i:s')->sortable(),
                TextColumn::make('updated_at')->dateTime('Y-m-d H:i:s')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'publish' => 'Publish',
                    ]),
                Filter::make('updated_at')
                    ->form([
                        Forms\Components\DateTimePicker::make('from')->label('Updated From'),
                        Forms\Components\DateTimePicker::make('until')->label('Updated Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $query, $date) => $query->where('updated_at', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $query, $date) => $query->where('updated_at', '<=', $date));
                    }),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStaticContents::route('/'),
            'create' => Pages\CreateStaticContent::route('/create'),
            'edit' => Pages\EditStaticContent::route('/{record}/edit'),
        ];
    }
}
