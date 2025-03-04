<?php

namespace App\Filament\AdminPanel\Resources;

use App\Filament\Actions\InvoiceDownloadAction;
use App\Filament\AdminPanel\Resources\RegistrationResource\Pages;
use App\Models\Registration;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Inscriptions';
    }

    public static function getModelLabel(): string
    {
        return 'Inscriptions';
    }

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
                Tables\Columns\TextColumn::make('walkers_count')
                    ->label('Nb marcheurs')
                    ->counts('walkers'),
                Tables\Columns\IconColumn::make('completed')
                    ->label('Inscription finalisée')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\IconColumn::make('newsletter_accepted')
                    ->boolean(),
                Tables\Columns\TextColumn::make('is_paid')
                    ->label('Payé')
                    ->state(fn(Registration $registration) => $registration->isPaid() ? 'Oui' : 'Non'),
                Tables\Columns\TextColumn::make('registration_date')
                    ->label('Date d\'inscription')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('is_paid')
                    ->query(fn(Builder $query) => $query->where('payment_date', 'IS NOT', null)),
            ])
            ->actions([
                Tables\Actions\Action::make('payment')
                    ->action(function (Registration $record) {
                        $record->payment_date = new \DateTime();
                        $record->save();
                    })
                    ->label(fn(Registration $record): string => $record->isPaid() ? 'Payé' : 'Payer')
                    ->tooltip(fn(Registration $record): string => $record->isPaid() ? '' : 'Payer')
                    ->disabled(fn(Registration $record): bool => $record->isPaid())
                    ->form(function (Form $form) {
                        return $form->schema([
                            Forms\Components\DatePicker::make('payment_date')
                                ->label('Date de paiment')
                                ->default(now())
                                ->required(),
                        ]);
                    })
                    ->requiresConfirmation()
                    ->icon('tabler-tax-euro')
                    ->modalIcon('tabler-pig-money')
                    ->color(
                        fn(Registration $registration): string => $registration->isPaid() ? 'success' : 'danger',
                    )
                    ->modalIconColor(
                        fn(Registration $registration): string => $registration->isPaid() ? 'success' : 'warning',
                    )
                    ->modalHeading(__('Payer la facture'))
                    ->modalDescription(__('Confirmer que la facture a été payée')),
                Tables\Actions\ViewAction::make()->label('Visualiser'),
                Tables\Actions\EditAction::make(),
                InvoiceDownloadAction::make(),
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
            'index' => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'view' => Pages\ViewRegistration::route('/{record}'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::getUser()->hasRole(Role::ROLE_ADMIN);
    }

}
