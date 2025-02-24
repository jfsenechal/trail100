<?php

namespace App\Filament\FrontPanel\Resources;

use App\Filament\FrontPanel\Resources\RegistrationResource\Pages;
use App\Filament\FrontPanel\Resources\RegistrationResource\RelationManagers\WalkersRelationManager;
use App\Models\Registration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration_date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ])
            ->headerActions([

            ]);
    }

    public static function getRelations(): array
    {
        return [
            WalkersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\CreateRegistration::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
            'complete' => Pages\RegistrationComplete::route('/{record}/complete'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.registration.navigation.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.registration.navigation.plural.model.label');
    }


}

//todo https://filamentphp.com/docs/3.x/panels/getting-started#casting-the-price-to-an-integer
