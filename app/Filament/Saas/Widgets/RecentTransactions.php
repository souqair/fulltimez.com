<?php

namespace App\Filament\Saas\Widgets;

use App\Models\Transaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTransactions extends BaseWidget
{
    protected static ?int $sort = 30;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Recent Transactions';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaction::query()
                    ->with('user')
                    ->latest('paid_at')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('paid_at')->dateTime('M j, Y H:i')->label('Paid at'),
                Tables\Columns\TextColumn::make('user.name')->label('User'),
                Tables\Columns\TextColumn::make('source_type')->formatStateUsing(fn ($state) => class_basename((string) $state))->label('Type'),
                Tables\Columns\TextColumn::make('total_amount_usd')->money('usd')->label('Total')->weight('bold'),
                Tables\Columns\BadgeColumn::make('country_key')->label('Country'),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'success' => 'succeeded', 'danger' => 'failed', 'gray' => 'pending',
                ]),
            ])
            ->paginated(false);
    }
}
