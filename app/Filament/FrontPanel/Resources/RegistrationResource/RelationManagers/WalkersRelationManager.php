<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\RelationManagers;

use App\Constant\DisplayNameEnum;
use App\Constant\TshirtEnum;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class WalkersRelationManager extends RelationManager
{
    protected static string $relationship = 'walkers';

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->live()
            ->reactive()
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Données nécessaires')
                        ->schema(
                            self::fieldsPersonal(),
                        ),
                    Wizard\Step::make('Contact')
                        ->schema(
                            self::fieldsContact(),
                        ),
                    Wizard\Step::make('T-shirt')
                        ->schema(
                            self::fieldsTshirt(),
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

    public static function fieldsPersonal(): array
    {
        return [
            TextInput::make('first_name')
                ->required()
                ->maxLength(150),
            TextInput::make('last_name')
                ->required()
                ->maxLength(150),
            TextInput::make('email')
                ->label('Email address')
                ->email()
                ->maxLength(150)
                ->autocomplete('email')
                ->required(),
        ];
    }

    public static function fieldsContact(): array
    {
        return [
            TextInput::make('phone')
                ->label('Phone number')
                ->tel(),
            TextInput::make('street')
                ->label('Street address')
                ->maxLength(150),
            TextInput::make('city')
                ->label('City')
                ->maxLength(150),
            TextInput::make('country')
                ->label('Country')
                ->maxLength(150),
            DatePicker::make('date_of_birth')
                ->label('Birthday')
                ->maxDate(now())
                ->date(),
        ];
    }

    public static function fieldsTshirt(): array
    {
        return [
            Select::make('tshirt')
                ->options(TshirtEnum::class)
                ->suffixIcon('heroicon-m-clipboard'),
        ];
    }

    public static function fieldsGdpr(): array
    {
        return [
            Select::make('display_name')
                ->options(DisplayNameEnum::class)
                ->helperText(
                    __('messages.display_name.select.help'),
                ),
            Checkbox::make('gdpr')
                ->helperText(__('messages.gdpr.select.help')),
            Placeholder::make('documentation')
                ->content(new HtmlString('<a href="/rgpd">filamentphp.com</a>')),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.walker.navigation.title');
    }
}
