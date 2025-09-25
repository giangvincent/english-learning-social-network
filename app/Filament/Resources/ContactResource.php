<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Schemas\Components\Fieldset;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-envelope';

    protected static string|null|\UnitEnum $navigationGroup = 'Content';

    public static function form(Form|\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form->schema([
            Fieldset::make('Contact')
                ->schema([
                    TextInput::make('email')->required()->email(),
                    TextInput::make('name')->required(),
                    TextInput::make('subject')->required(),
                    Textarea::make('content')->rows(6)->required()->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('subject')->searchable(),
                TextColumn::make('content')->limit(80)->wrap(),
                TextColumn::make('created_at')->dateTime('Y-m-d H:i:s')->sortable(),
                TextColumn::make('updated_at')->dateTime('Y-m-d H:i:s')->sortable(),
            ])
            ->filters([
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
                ViewAction::make(),
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
