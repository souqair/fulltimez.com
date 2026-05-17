<?php

namespace App\Filament\Saas\Resources;

use App\Filament\Saas\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Customers';
    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')->relationship('user', 'name')->searchable(),
            Forms\Components\TextInput::make('source_type'),
            Forms\Components\TextInput::make('source_id')->numeric(),
            Forms\Components\TextInput::make('stripe_payment_intent_id'),
            Forms\Components\TextInput::make('stripe_invoice_id'),
            Forms\Components\TextInput::make('base_amount_usd')->numeric()->prefix('$'),
            Forms\Components\TextInput::make('vat_amount_usd')->numeric()->prefix('$'),
            Forms\Components\TextInput::make('total_amount_usd')->numeric()->prefix('$'),
            Forms\Components\Select::make('status')->options([
                'pending' => 'Pending', 'succeeded' => 'Succeeded', 'failed' => 'Failed', 'refunded' => 'Refunded', 'partial_refund' => 'Partial Refund',
            ])->required(),
            Forms\Components\Textarea::make('failure_reason')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paid_at')->dateTime('M j, Y H:i')->sortable()->label('Paid at'),
                Tables\Columns\TextColumn::make('user.name')->searchable()->label('User'),
                Tables\Columns\TextColumn::make('source_type')->formatStateUsing(fn ($state) => class_basename((string) $state))->label('Source'),
                Tables\Columns\TextColumn::make('base_amount_usd')->money('usd')->label('Base'),
                Tables\Columns\TextColumn::make('vat_amount_usd')->money('usd')->label('VAT'),
                Tables\Columns\TextColumn::make('total_amount_usd')->money('usd')->label('Total')->weight('bold'),
                Tables\Columns\BadgeColumn::make('country_key')->label('Country'),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'success' => 'succeeded', 'danger' => 'failed', 'warning' => fn ($s) => in_array($s, ['refunded', 'partial_refund']), 'gray' => 'pending',
                ]),
            ])
            ->defaultSort('paid_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(['succeeded' => 'Succeeded', 'failed' => 'Failed', 'refunded' => 'Refunded', 'pending' => 'Pending']),
                Tables\Filters\SelectFilter::make('country_key')->options(['pk' => 'PK', 'ae' => 'AE', 'sa' => 'SA', 'global' => 'Global']),
            ])
            ->actions([Tables\Actions\ViewAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit'   => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
