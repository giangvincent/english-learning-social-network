<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Schemas\Components\Fieldset;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|null|\UnitEnum $navigationGroup = 'Accounts';

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-users';

    public static function form(Form|\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form->schema([
            Fieldset::make('User')
                ->schema([
                    TextInput::make('full_name')->required(),
                    TextInput::make('nick_name'),
                    FileUpload::make('avatar')
                        ->directory('images/avatars')
                        ->disk('admin')
                        ->image(),
                    TextInput::make('email')->email()->required(),
                    TextInput::make('phone'),
                    DatePicker::make('birthday'),
                    Toggle::make('is_admin')->label('Administrator'),
                    TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->dehydrateStateUsing(fn (?string $state) => filled($state) ? Hash::make($state) : null)
                        ->required(fn (string $context): bool => $context === 'create')
                        ->dehydrated(fn (?string $state): bool => filled($state)),
                    TextInput::make('password_confirmation')
                        ->password()
                        ->required(fn (string $context): bool => $context === 'create')
                        ->same('password')
                        ->dehydrated(false),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('full_name')->searchable()->sortable(),
                TextColumn::make('nick_name')->searchable(),
                ImageColumn::make('avatar')->disk('admin')->height(40)->width(40),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('birthday')->date(),
                IconColumn::make('is_admin')
                    ->label('Administrator')
                    ->boolean(),
                TextColumn::make('created_at')->dateTime('Y-m-d H:i:s')->sortable(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DateTimePicker::make('from')->label('Joined From'),
                        Forms\Components\DateTimePicker::make('until')->label('Joined Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $query, $date) => $query->where('created_at', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $query, $date) => $query->where('created_at', '<=', $date));
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
