<?php

namespace App\Filament\AdminPanel\Resources;

use App\Constant\TshirtEnum;
use App\Filament\AdminPanel\Resources\WalkerResource\Pages;
use App\Models\Registration;
use App\Models\Role;
use App\Models\Walker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class WalkerResource extends Resource
{
    protected static ?string $model = Walker::class;

    protected static ?string $navigationIcon = 'tabler-walk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('street')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('city')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('country')
                    ->maxLength(255)
                    ->default('Belgium'),
                Forms\Components\DatePicker::make('date_of_birth'),
                Forms\Components\TextInput::make('club_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('tshirt_size')
                    ->required()
                    ->maxLength(255)
                    ->default(TshirtEnum::NO->value),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tshirt_size')
                    ->label('T-shirt')
                    ->badge()->size('xxl')
                    ->color(fn(TshirtEnum $state): string => $state->getColor())
                    ->icon(fn(TshirtEnum $state): string => $state->getIcon()),
                Tables\Columns\TextColumn::make('registration_id')
                    ->state(fn(Registration $x) => $x->email)
                    ->searchable(),
                IconColumn::make('registration.payement_date')
                    ->boolean(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('club_name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListWalkers::route('/'),
            'create' => Pages\CreateWalker::route('/create'),
            'view' => Pages\ViewWalker::route('/{record}'),
            'edit' => Pages\EditWalker::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::getUser()->hasRole(Role::ROLE_ADMIN);
    }
}
