<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\RelationManagers;

use App\Constant\TshirtEnum;
use App\Filament\FrontPanel\Resources\WalkerResource;
use Filament\Forms\Components\Wizard;
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
            ->columns(1)
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Données nécessaires')
                        ->schema(
                            WalkerResource::fieldsPersonal(),
                        ),
                    Wizard\Step::make('Contact')
                        ->schema(
                            WalkerResource::fieldsContact(),
                        ),
                    Wizard\Step::make('T-shirt')
                        ->schema(
                            WalkerResource::fieldsTshirt(),
                        ),
                ]),
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
                Tables\Columns\TextColumn::make('email')
                    ->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('tshirt_size')
                    ->badge()->size('xxl')
                    ->color(fn(TshirtEnum $state): string => $state->getColor())
                    ->icon(fn(TshirtEnum $state): string => $state->getIcon()),
                Tables\Columns\TextColumn::make('email'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->createAnother(false),
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
