<?php

namespace App\Filament\Widgets;

use App\Models\Consulta;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ConsultasChart extends ChartWidget
{
    protected static ?int $sort = 1;

    protected static ?string $heading = 'Consultas no mês';

    protected function getData(): array
    {
        $data = Trend::query(Consulta::query()->where('loja_id', Filament::getTenant()->id))
            ->dateColumn('data')
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Consultas por dia',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => Carbon::parse($value->date)->format('d/m')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
