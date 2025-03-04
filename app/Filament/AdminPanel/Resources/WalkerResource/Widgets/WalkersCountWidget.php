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
            Stat::make('Marcheurs validés', $walkersCountPaid)
                ->description('Nombre de marcheurs payés')
                ->icon('tabler-walk')
                ->color('success')                ,

            Stat::make('Marcheurs non validés', $walkersCountUnpaid)
                ->description('Nombre de marcheurs non payés')
                ->icon('tabler-walk')
                ->color('danger'),

            Stat::make('Inscriptions payées', Registration::whereNotNull('payment_date')->count())
                ->description('Date de paiement validée')
                ->icon('tabler-currency-euro')
                ->color('success'),

            Stat::make('Inscriptions non payées', Registration::whereNull('payment_date')->count())
                ->description('Pas de date de paiement')
                ->icon('tabler-currency-euro-off')
                ->color('danger'),
        ];
    }
}
