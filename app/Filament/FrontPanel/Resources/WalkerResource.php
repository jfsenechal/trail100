<?php

namespace App\Filament\FrontPanel\Resources;

use App\Filament\FrontPanel\Resources\WalkerResource\Pages;
use App\Models\Walker;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WalkerResource extends Resource
{
    protected static ?string $model = Walker::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Coordonnées')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(150),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(150),
                        Forms\Components\TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->maxLength(150),
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone number')
                            ->tel(),
                        Forms\Components\TextInput::make('street')
                            ->label('Street address')
                            ->maxLength(150),
                        Forms\Components\TextInput::make('city')
                            ->label('City')
                            ->maxLength(150),
                        Forms\Components\TextInput::make('country')
                            ->label('Country')
                            ->maxLength(150),
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->label('Birthday')
                            ->date(),
                    ]),
                Section::make('Infos')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('tshirt_size')
                            ->label('T-shirt size')
                            ->options([
                                'XS' => 'XS',
                                'S' => 'S',
                                'M' => 'M',
                                'L' => 'L',
                                'Xl' => 'XL',
                                'XXL' => 'XXL',
                            ]),
                        Forms\Components\TextInput::make('club_name')
                            ->label('Club name')
                            ->maxLength(150),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->searchable(),
                Tables\Columns\TextColumn::make('last_name')->searchable(),
                Tables\Columns\TextColumn::make('city')->searchable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('email')->searchable(),
                //Tables\Columns\TextColumn::make('walkers')->counts('walkers'),
            ])
            ->filters([

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
}

//todo https://filamentphp.com/docs/3.x/panels/getting-started#casting-the-price-to-an-integer
