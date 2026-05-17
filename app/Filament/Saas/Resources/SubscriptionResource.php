<?php

namespace App\Filament\Saas\Resources;

use App\Filament\Saas\Resources\SubscriptionResource\Pages;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Customers';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')->relationship('user', 'name')->searchable()->required(),
            Forms\Components\Select::make('plan_id')->relationship('plan', 'name')->required(),
            Forms\Components\Select::make('status')->options([
                'incomplete' => 'Incomplete',
                'active' => 'Active',
                'past_due' => 'Past Due',
                'canceled' => 'Canceled',
                'paused' => 'Paused',
            ])->required(),
            Forms\Components\Select::make('billing_cycle')->options(['monthly' => 'Monthly', 'yearly' => 'Yearly'])->required(),
            Forms\Components\TextInput::make('country_key'),
            Forms\Components\TextInput::make('vat_rate')->numeric()->suffix('%'),
            Forms\Components\TextInput::make('base_amount_usd')->numeric()->prefix('$'),
            Forms\Components\TextInput::make('vat_amount_usd')->numeric()->prefix('$'),
            Forms\Components\TextInput::make('total_amount_usd')->numeric()->prefix('$'),
            Forms\Components\TextInput::make('stripe_subscription_id')->disabled(),
            Forms\Components\DateTimePicker::make('current_period_end'),
            Forms\Components\DateTimePicker::make('canceled_at'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('user.name')->searchable()->label('User'),
                Tables\Columns\TextColumn::make('user.email')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('plan.name')->label('Plan'),
                Tables\Columns\BadgeColumn::make('billing_cycle'),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'success' => 'active',
                    'warning' => 'past_due',
                    'danger'  => 'canceled',
                    'gray'    => fn ($state) => in_array($state, ['incomplete', 'paused']),
                ]),
                Tables\Columns\BadgeColumn::make('country_key')->label('Country'),
                Tables\Columns\TextColumn::make('total_amount_usd')->money('usd')->label('Total'),
                Tables\Columns\TextColumn::make('current_period_end')->dateTime('M j, Y')->label('Renews'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'active' => 'Active', 'past_due' => 'Past Due', 'canceled' => 'Canceled', 'incomplete' => 'Incomplete',
                ]),
                Tables\Filters\SelectFilter::make('country_key')->options(['pk' => 'PK', 'ae' => 'AE', 'sa' => 'SA', 'global' => 'Global']),
                Tables\Filters\SelectFilter::make('billing_cycle')->options(['monthly' => 'Monthly', 'yearly' => 'Yearly']),
                Tables\Filters\SelectFilter::make('plan_id')->relationship('plan', 'name')->label('Plan'),
            ])
            ->actions([Tables\Actions\ViewAction::make(), Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit'   => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
