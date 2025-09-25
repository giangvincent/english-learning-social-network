<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Repositories\ExportJson;
use Illuminate\Support\Facades\File;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Schemas\Components\Fieldset;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-document-text';

    protected static string|null|\UnitEnum $navigationGroup = 'Content';

    public static function form(Form|\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form->schema([
            Fieldset::make('Metadata')
                ->schema([
                    TextInput::make('pid')
                        ->disabled()
                        ->dehydrated(),
                    Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'publish' => 'Publish',
                        ])
                        ->required(),
                    TextInput::make('subject')
                        ->required()
                        ->columnSpanFull(),
                    Select::make('type')
                        ->options([
                            'normalPost' => 'Normal Post',
                            'flashCard' => 'Flash Card',
                            'quiz' => 'Quiz',
                        ])
                        ->required(),
                    Select::make('category')
                        ->label('Category')
                        ->options(fn () => Category::orderBy('name')->pluck('name', 'id')->toArray())
                        ->searchable()
                        ->required(),
                    Select::make('author')
                        ->label('Author')
                        ->options(fn () => User::orderBy('full_name')->pluck('full_name', 'id')->toArray())
                        ->default(fn () => auth()->id())
                        ->searchable()
                        ->required(),
                    Select::make('tags')
                        ->label('Tags')
                        ->relationship('tags', 'name')
                        ->multiple()
                        ->searchable()
                        ->preload(),
                ])
                ->columns(2),
            Fieldset::make('Content')
                ->schema([
                    Textarea::make('content')
                        ->rows(12)
                        ->required()
                        ->columnSpanFull(),
                    Textarea::make('answer_list')
                        ->rows(4)
                        ->columnSpanFull(),
                ])->columns(1),
            Fieldset::make('Statistics')
                ->schema([
                    TextInput::make('nums_bagged')->numeric()->default(0),
                    TextInput::make('nums_good')->numeric()->default(0),
                    TextInput::make('nums_bad')->numeric()->default(0),
                    TextInput::make('nums_share')->numeric()->default(0),
                    TextInput::make('nums_comment')->numeric()->default(0),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('subject')->wrap()->limit(40)->searchable(),
                TextColumn::make('content')
                    ->label('Content Summary')
                    ->formatStateUsing(function (?string $state): string {
                        if (blank($state)) {
                            return '';
                        }

                        $content = json_decode($state, true);
                        if (! is_array($content)) {
                            return Str::limit(strip_tags($state), 120);
                        }

                        $summary = [];
                        $summary[] = 'Paragraphs: ' . count($content);
                        foreach (array_slice($content, 0, 3) as $item) {
                            $summary[] = strip_tags($item['contentHtml'] ?? '');
                        }

                        return implode("\n", array_filter($summary));
                    })
                    ->toggleable()
                    ->wrap()
                    ->limit(120),
                TextColumn::make('type')->badge()->sortable(),
                TextColumn::make('user.full_name')->label('Author'),
                TextColumn::make('categoryRelated.name')->label('Category'),
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
                SelectFilter::make('type')
                    ->options([
                        'normalPost' => 'Normal Post',
                        'flashCard' => 'Flash Card',
                        'quiz' => 'Quiz',
                    ]),
                SelectFilter::make('category')
                    ->relationship('categoryRelated', 'name'),
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
                    ->after(function (Post $record): void {
                        $jsonPath = public_path('dist/content/posts/' . $record->pid . '.json');
                        if (File::exists($jsonPath)) {
                            File::delete($jsonPath);
                        }

                        ExportJson::feedToJson('home');
                        ExportJson::feedToJson('category');
                    }),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->after(function (): void {
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
