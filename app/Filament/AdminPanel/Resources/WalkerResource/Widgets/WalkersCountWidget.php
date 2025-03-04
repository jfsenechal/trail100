<?php

namespace App\Filament\AdminPanel\Resources\WalkerResource\Widgets;

use App\Models\Registration;
use App\Models\Walker;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WalkersCountWidget extends BaseWidget
{
    protected ?string $heading = 'Statistiques';

    protected ?string $description = 'Quelques statistiques.';

    protected function getStats(): array
    {
        $walkersCountUnpaid = Walker::whereHas('registration', function ($query) {
            $query->whereNull('payment_date');
        })->count();
        $walkersCountPaid = Walker::whereHas('registration', function ($query) {
            $query->whereNotNull('payment_date');
        })->count();

        return [
            Stat::make('Marcheurs', $walkersCountPaid)
                ->description('Nombre de marcheurs payés')
                ->descriptionIcon('tabler-walk')
                ->color('success'),

            Stat::make('Marcheurs', $walkersCountUnpaid)
                ->description('Nombre de marcheurs non payés')
                ->descriptionIcon('tabler-walk')
                ->color('danger'),

            Stat::make('Inscriptions payées', Registration::whereNotNull('payment_date')->count())
                ->description('Date de paiement validée')
                ->descriptionIcon('tabler-currency-euro')
                ->color('success'),

            Stat::make('Inscriptions non payées', Registration::whereNull('payment_date')->count())
                ->description('Pas de date de paiement')
                ->descriptionIcon('tabler-currency-euro-off')
                ->color('danger'),
        ];
    }
}
