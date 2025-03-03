<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\RelationManagers;

use App\Constant\DisplayNameEnum;
use App\Constant\TshirtEnum;
use App\Models\Walker;
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
use Illuminate\Database\Eloquent\Model;
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
                    Wizard\Step::make('necessary_data')
                        ->label(__('messages.form.registration.walkers.step1.label'))
                        ->schema(
                            self::fieldsPersonal(),
                        ),
                    Wizard\Step::make('contact')
                        ->label(__('messages.form.registration.walkers.step2.label'))
                        ->schema(
                            self::fieldsContact(),
                        ),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            ->emptyStateDescription(__('messages.form.registration.walkers.empty.label'))
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->label(__('messages.first_name')),
                Tables\Columns\TextColumn::make('last_name')
                    ->label(__('messages.last_name')),
                Tables\Columns\TextColumn::make('city')
                    ->label(__('messages.city')),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('messages.email'))
                    ->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('tshirt_size')
                    ->label(__('invoices::messages.tshirt.label'))
                    ->badge()->size('xxl')
                    ->color(fn(TshirtEnum $state): string => $state->getColor())
                    ->icon(fn(TshirtEnum $state): string => $state->getIcon()),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('invoices::messages.invoice.price'))
                    ->state(fn(Walker $walker) => $walker->amountInWords()),
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

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('messages.form.registration.walkers.label');
    }

    public static function fieldsPersonal(): array
    {
        return [
            TextInput::make('first_name')
                ->label(__('messages.first_name'))
                ->required()
                ->maxLength(150),
            TextInput::make('last_name')
                ->label(__('messages.last_name'))
                ->required()
                ->maxLength(150),
            TextInput::make('email')
                ->label(__('messages.email'))
                ->email()
                ->suffixIcon('tabler-mail')
                ->maxLength(150)
                ->autocomplete('email')
                ->required(),
            Select::make('tshirt_size')
                ->label(__('messages.tshirt_size'))
                ->helperText(__('messages.tshirt.cost'))
                ->default(TshirtEnum::NO->value)
                ->options(TshirtEnum::class)
                ->suffixIcon('tabler-shirt-sport'),
        ];
    }

    public static function fieldsContact(): array
    {
        return [
            TextInput::make('phone')
                ->label(__('messages.phone'))
                ->tel(),
            TextInput::make('street')
                ->label(__('messages.street'))
                ->maxLength(150),
            TextInput::make('city')
                ->label(__('messages.city'))
                ->maxLength(150),
            TextInput::make('country')
                ->label(__('messages.country'))
                ->maxLength(150),
            DatePicker::make('date_of_birth')
                ->label(__('messages.date_of_birth'))
                ->maxDate(now())
                ->date(),
        ];
    }

    public static function fieldsGdpr(): array
    {
        return [
            Select::make('display_name')
                ->label(__('messages.display_name'))
                ->options(DisplayNameEnum::class)
                ->helperText(
                    __('messages.display_name.select.help'),
                ),
            Checkbox::make('gdpr_accepted')
                ->label(__('messages.gdpr_accepted'))
                ->helperText(__('messages.gdpr.select.help')),
            Placeholder::make('documentation')
                ->label(__('messages.documentation'))
                ->content(new HtmlString('<a href="/rgpd">filamentphp.com</a>')),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.walker.navigation.title');
    }
}
