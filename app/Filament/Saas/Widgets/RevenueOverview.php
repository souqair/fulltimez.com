<?php

namespace App\Filament\Saas\Widgets;

use App\Models\Subscription;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenueOverview extends BaseWidget
{
    protected static ?int $sort = 10;

    protected function getStats(): array
    {
        $now = now();

        $mrr = (float) Subscription::active()
            ->where('billing_cycle', 'monthly')
            ->sum('total_amount_usd')
            + ((float) Subscription::active()->where('billing_cycle', 'yearly')->sum('total_amount_usd') / 12);

        $thisMonthRevenue = (float) Transaction::where('status', 'succeeded')
            ->whereBetween('paid_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])
            ->sum('total_amount_usd');

        $allTimeRevenue = (float) Transaction::where('status', 'succeeded')->sum('total_amount_usd');

        $activeSubs = Subscription::active()->count();
        $churnSubs  = Subscription::where('status', 'canceled')
            ->whereBetween('canceled_at', [$now->copy()->subDays(30), $now])
            ->count();

        return [
            Stat::make('MRR (Monthly Recurring)', '$' . number_format($mrr, 2))
                ->description('Active subs, monthly equivalent')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Revenue this month', '$' . number_format($thisMonthRevenue, 2))
                ->description('Includes one-time + subscription invoices')
                ->color('primary'),

            Stat::make('All-time revenue', '$' . number_format($allTimeRevenue, 2))
                ->color('gray'),

            Stat::make('Active subscriptions', $activeSubs)
                ->description($churnSubs . ' canceled in last 30 days')
                ->color($churnSubs > 0 ? 'warning' : 'success'),
        ];
    }
}
