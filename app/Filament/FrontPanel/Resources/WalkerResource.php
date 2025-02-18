<?php

namespace App\Filament\FrontPanel\Resources;

use App\Constant\DisplayNameEnum;
use App\Constant\TshirtEnum;
use App\Filament\FrontPanel\Resources\WalkerResource\Pages;
use App\Models\Walker;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class WalkerResource extends Resource
{
    protected static ?string $model = Walker::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Repeater::make('walkers')
                    ->reorderable(false)
                    ->defaultItems(0)
                    ->minItems(1)
                    ->columnSpanFull(2)
                    ->collapsible()
                    ->collapseAllAction(
                        fn(Action $action) => $action->label('Collapse all walkers'),
                    )
                    ->live()
                    ->itemLabel(
                        fn(array $state): string => $state['title'] ?? $state['first_name'].' '.$state['last_name'],
                    )
                    ->addActionLabel(__('messages.form.walker.btn.add.label'))
                    ->addActionAlignment(Alignment::Start)
                    ->schema(
                        [
                            Section::make(__('messages.form.walker.section.personal'))
                                ->columns(2)
                                ->schema(self::fieldsPersonal()),
                            Section::make(__('messages.form.walker.section.contact'))
                                ->columns(2)
                                ->schema(self::fieldsContact()),
                            Section::make(__('messages.form.walker.section.tshirt'))
                                ->description(__('messages.form.tshirt.section.description'))
                                ->columns(2)
                                ->schema(self::fieldsTshirt()),
                            Section::make(__('messages.form.walker.section.gdpr'))
                                ->columns(2)
                                ->schema(self::fieldsGdpr()),
                        ],
                    ),
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
        ];
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

    public static function fieldsContact(): array
    {
        return [
            TextInput::make('email')
                ->label('Email address')
                ->email()
                ->maxLength(150)
                ->autocomplete('email')
                ->required(),
            TextInput::make('phone')
                ->label('Phone number')
                ->tel(),
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

//todo https://filamentphp.com/docs/3.x/panels/getting-started#casting-the-price-to-an-integer
