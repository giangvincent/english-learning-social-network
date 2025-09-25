<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use App\Services\AdminContentExporter;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-folder';

    protected static string|null|\UnitEnum $navigationGroup = 'Content';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form|\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form->schema([
            Fieldset::make('Category')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, ?string $state): void {
                            if (filled($state)) {
                                $set('slug', Str::slug($state));
                            }
                        }),
                    TextInput::make('slug')
                        ->disabled()
                        ->dehydrated()
                        ->required(),
                    Textarea::make('description')
                        ->columnSpanFull(),
                    FileUpload::make('cover')
                        ->label('Cover')
                        ->directory('images/categories')
                        ->disk('admin')
                        ->image()
                        ->imageEditor()
                        ->columnSpanFull(),
                    Select::make('parent')
                        ->label('Parent')
                        ->options(fn (?Category $record): array => Category::query()
                            ->when($record, fn (Builder $query) => $query->whereKeyNot($record->getKey()))
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray())
                        ->searchable()
                        ->nullable(),
                    Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'publish' => 'Publish',
                        ])
                        ->required(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('description')->limit(50),
                ImageColumn::make('cover')->disk('admin'),
                TextColumn::make('parentCategory.name')->label('Parent'),
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
                    ->after(function (Category $record): void {
                        $path = public_path('dist/content/categories/' . $record->slug . '.json');
                        if (file_exists($path)) {
                            unlink($path);
                        }

                        AdminContentExporter::syncCategoriesFeed();
                        AdminContentExporter::notifyPostUpdateForCategory($record->id);
                    }),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->after(function (): void {
                        AdminContentExporter::syncCategoriesFeed();
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
