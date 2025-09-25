<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Models\Tag;
use App\Repositories\ExportJson;
use App\Services\AdminContentExporter;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
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

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static string|null|\UnitEnum $navigationGroup = 'Content';

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-tag';

    public static function form(Form|\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form->schema([
            Fieldset::make('Tag')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, ?string $state): void {
                            if (filled($state)) {
                                $set('name', Str::of($state)->lower());
                                $set('slug', Str::slug($state));
                            }
                        }),
                    TextInput::make('slug')
                        ->disabled()
                        ->dehydrated()
                        ->required(),
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
                TextColumn::make('name')->searchable()->sortable(),
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
                DeleteAction::make()
                    ->after(function (): void {
                        AdminContentExporter::syncTagsFeed();
                        ExportJson::feedToJson('home');
                        ExportJson::feedToJson('category');
                    }),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->after(function (): void {
                        AdminContentExporter::syncTagsFeed();
                        ExportJson::feedToJson('home');
                        ExportJson::feedToJson('category');
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
