<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class WalkersRelationManager extends RelationManager
{
    protected static string $relationship = 'walkers';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->autocomplete(false)
                    ->maxLength(150),
                Forms\Components\TextInput::make('last_name')
                    ->autocomplete(false)
                    ->maxLength(150),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->prefixIcon('heroicon-m-at-symbol')
                    ->autocomplete(false)
                    ->maxLength(150),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            ->columns([
                Tables\Columns\TextColumn::make('first_name'),
                Tables\Columns\TextColumn::make('last_name'),
                Tables\Columns\TextColumn::make('city'),
                Tables\Columns\TextColumn::make('email'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
            Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
