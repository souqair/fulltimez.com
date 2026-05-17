<?php

namespace App\Filament\Saas\Widgets;

use App\Models\Subscription;
use Filament\Widgets\ChartWidget;

class SubscriptionsByCountry extends ChartWidget
{
    protected static ?string $heading = 'Active subscriptions by country';
    protected static ?int $sort = 20;

    protected function getData(): array
    {
        $rows = Subscription::active()
            ->selectRaw('country_key, count(*) as total')
            ->groupBy('country_key')
            ->pluck('total', 'country_key')
            ->all();

        $labels = ['Pakistan', 'UAE', 'Saudi Arabia', 'Global'];
        $keys   = ['pk', 'ae', 'sa', 'global'];
        $values = [];
        foreach ($keys as $key) {
            $values[] = (int) ($rows[$key] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Active subscriptions',
                    'data'  => $values,
                    'backgroundColor' => ['#2563eb', '#16a34a', '#f59e0b', '#6b7280'],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
