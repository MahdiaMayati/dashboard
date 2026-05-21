<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrdersByStatusChart extends ChartWidget
{
    protected ?string $heading = 'Orders by status';

    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];

    protected function getType(): string
    {
        return 'bar';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        $counts = Order::query()
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $labels = $counts->keys()->map(function (string $value): string {
            $enum = OrderStatus::tryFrom($value);

            return $enum ? (string) str($enum->name)->headline() : $value;
        })->values()->all();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $counts->values()->all(),
                ],
            ],
        ];
    }
}
