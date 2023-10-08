<?php

namespace App\Filament\Widgets;

use App\Models\Paciente;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PetsChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Total de Pets Cadastrados';

    protected function getData(): array
    {
        setlocale(LC_TIME, 'pt_BR.utf8');
        $data = Trend::model(Paciente::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Pets Cadastrados',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => strtoupper(Carbon::parse($value->date)->isoFormat('MMM'))),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
