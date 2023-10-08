<?php

namespace App\Filament\Widgets;

use App\Models\Consulta;
use App\Models\ContasAPagar;
use App\Models\ContasAReceber;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $entradas = ContasAReceber::query()
            ->where('loja_id', Filament::getTenant()->id)
            ->where('data_recebimento', '>=', now()->startOfMonth())
            ->where('data_recebimento', '<=', now()->endOfMonth())
            ->sum('valor_pago');

        $saidas = ContasAPagar::query()
            ->where('loja_id', Filament::getTenant()->id)
            ->where('data_pagamento', '>=', now()->startOfMonth())
            ->where('data_pagamento', '<=', now()->endOfMonth())
            ->sum('valor_pago');

        $vendas = ContasAReceber::query()
            ->where('loja_id', Filament::getTenant()->id)
            ->where('tipo', 'Venda')
            ->where('data_recebimento', '>=', now()->startOfMonth())
            ->where('data_recebimento', '<=', now()->endOfMonth())
            ->sum('valor_pago');

        $consultas = Consulta::query()
            ->where('loja_id', Filament::getTenant()->id)
            ->where('data', '>=', now()->startOfMonth())
            ->where('data', '<=', now()->endOfMonth())
            ->count();

        return [
            Stat::make('Entradas', "R$ " . number_format($entradas, 2, ',', '.'))
                ->description('Total de Entradas este mês')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Saídas', "R$ " . number_format($saidas, 2, ',', '.'))
                ->description('Total de Saídas este mês')
                ->chart([7, 10, 2, 17, 15, 4])
                ->color('danger'),
            Stat::make('Vendas', "R$ " . number_format($vendas, 2, ',', '.'))
                ->description('Total de Vendas este mês')
                ->color('success'),
            Stat::make('Consultas', $consultas)
                ->description('Total de Consultas este mês')
                ->color('success'),
        ];
    }
}
