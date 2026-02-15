<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Inscritos extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $tortal = User::count();
        $em_analise = User::where('status', 'analyzing')->count();
        $pendente = User::where('status', 'pending')->count();
        return [
            Stat::make('total_inscritos', $tortal)
                ->label('Total de Inscritos')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('info')
                ->value($tortal),
            Stat::make('inscritos_analise', $em_analise)
                ->label('Inscritos em Análise')
                ->chart([5, 1, 8, 2, 12, 3, 14])
                ->color('success')
                ->value($em_analise),
            Stat::make('inscritos_pendente', $pendente)
                ->label('Inscritos Pendentes')
                ->chart([3, 1, 4, 2, 5, 1, 6])
                ->color('success')
                ->value($pendente),
        ];
    }
}
