<?php

namespace App\Filament\Saas\Resources;

use App\Filament\Saas\Resources\PlanResource\Pages;
use App\Models\Plan;
use App\Services\StripeService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Billing';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Plan details')->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(120),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true)->maxLength(120),
                Forms\Components\Textarea::make('description')->rows(3)->columnSpanFull(),
                Forms\Components\Select::make('type')
                    ->options(['subscription' => 'Subscription', 'one_time' => 'One-time'])
                    ->required()
                    ->live(),
                Forms\Components\TextInput::make('cta_label')->placeholder('Subscribe Now'),
                Forms\Components\TagsInput::make('features')->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Pricing (USD, before VAT)')->schema([
                Forms\Components\TextInput::make('price_monthly_usd')->numeric()->prefix('$')->visible(fn (Forms\Get $get) => $get('type') === 'subscription'),
                Forms\Components\TextInput::make('price_yearly_usd')->numeric()->prefix('$')->visible(fn (Forms\Get $get) => $get('type') === 'subscription'),
                Forms\Components\TextInput::make('price_onetime_usd')->numeric()->prefix('$')->visible(fn (Forms\Get $get) => $get('type') === 'one_time'),
            ])->columns(3),

            Forms\Components\Section::make('Stripe (auto-filled on sync)')->schema([
                Forms\Components\TextInput::make('stripe_product_id')->disabled(),
                Forms\Components\TextInput::make('stripe_price_id_monthly')->disabled(),
                Forms\Components\TextInput::make('stripe_price_id_yearly')->disabled(),
                Forms\Components\TextInput::make('stripe_price_id_onetime')->disabled(),
            ])->columns(2)->collapsible()->collapsed(),

            Forms\Components\Section::make('Visibility')->schema([
                Forms\Components\Toggle::make('is_active')->default(true),
                Forms\Components\Toggle::make('is_featured'),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('type')->colors(['primary' => 'subscription', 'warning' => 'one_time']),
                Tables\Columns\TextColumn::make('price_monthly_usd')->money('usd')->label('Monthly'),
                Tables\Columns\TextColumn::make('price_yearly_usd')->money('usd')->label('Yearly'),
                Tables\Columns\TextColumn::make('price_onetime_usd')->money('usd')->label('One-time'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\IconColumn::make('is_featured')->boolean(),
                Tables\Columns\TextColumn::make('stripe_product_id')->label('Stripe')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('type')->options(['subscription' => 'Subscription', 'one_time' => 'One-time']),
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\Action::make('sync_stripe')
                    ->label('Sync to Stripe')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Plan $record) {
                        try {
                            app(StripeService::class)->syncPlan($record);
                            Notification::make()->success()->title('Synced to Stripe')->send();
                        } catch (\Throwable $e) {
                            Notification::make()->danger()->title('Sync failed')->body($e->getMessage())->send();
                        }
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit'   => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
