<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PostsChart extends ChartWidget
{
    protected static ?string $heading = 'Statystyki Postów';
    
    protected static ?int $sort = 2; // Opcjonalnie: kolejność na pulpicie

    protected function getData(): array
    {
        // Pobieramy dane z bazy: liczba postów na miesiąc w bieżącym roku
        $data = Trend::model(Post::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Liczba postów',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#f59e0b', // Kolor linii (opcjonalny, np. pomarańczowy)
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}