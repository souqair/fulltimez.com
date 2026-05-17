<?php

namespace App\Filament\Saas\Resources;

use App\Filament\Saas\Resources\AtsCvPurchaseResource\Pages;
use App\Jobs\GenerateAtsCv;
use App\Models\AtsCvPurchase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AtsCvPurchaseResource extends Resource
{
    protected static ?string $model = AtsCvPurchase::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Customers';
    protected static ?int $navigationSort = 20;
    protected static ?string $label = 'ATS CV Purchase';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')->relationship('user', 'name')->searchable()->required(),
            Forms\Components\Select::make('plan_id')->relationship('plan', 'name'),
            Forms\Components\Select::make('status')->options([
                'pending_payment' => 'Pending Payment',
                'paid'            => 'Paid',
                'generating'      => 'Generating',
                'completed'       => 'Completed',
                'failed'          => 'Failed',
                'refunded'        => 'Refunded',
            ])->required(),
            Forms\Components\TextInput::make('ats_score')->numeric(),
            Forms\Components\TextInput::make('source_cv_path')->disabled(),
            Forms\Components\TextInput::make('generated_cv_path')->disabled(),
            Forms\Components\KeyValue::make('rewrite_payload')->columnSpanFull(),
            Forms\Components\Textarea::make('error_message')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('user.name')->searchable()->label('User'),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'success' => 'completed',
                    'warning' => fn ($state) => in_array($state, ['paid', 'generating']),
                    'danger'  => 'failed',
                    'gray'    => 'pending_payment',
                ]),
                Tables\Columns\TextColumn::make('ats_score')->suffix('/100'),
                Tables\Columns\TextColumn::make('total_amount_usd')->money('usd')->label('Total'),
                Tables\Columns\BadgeColumn::make('country_key')->label('Country'),
                Tables\Columns\TextColumn::make('paid_at')->dateTime('M j, Y'),
                Tables\Columns\TextColumn::make('completed_at')->dateTime('M j, Y'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'completed' => 'Completed', 'failed' => 'Failed', 'paid' => 'Paid', 'generating' => 'Generating', 'pending_payment' => 'Pending', 'refunded' => 'Refunded',
                ]),
                Tables\Filters\SelectFilter::make('country_key')->options(['pk' => 'PK', 'ae' => 'AE', 'sa' => 'SA', 'global' => 'Global']),
            ])
            ->actions([
                Tables\Actions\Action::make('retry')
                    ->label('Retry generation')
                    ->icon('heroicon-o-arrow-path')
                    ->visible(fn (AtsCvPurchase $record) => in_array($record->status, ['failed', 'paid']))
                    ->requiresConfirmation()
                    ->action(function (AtsCvPurchase $record) {
                        $record->update(['status' => 'generating', 'error_message' => null]);
                        GenerateAtsCv::dispatch($record->id);
                        Notification::make()->success()->title('Generation re-queued')->send();
                    }),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAtsCvPurchases::route('/'),
            'create' => Pages\CreateAtsCvPurchase::route('/create'),
            'edit'   => Pages\EditAtsCvPurchase::route('/{record}/edit'),
        ];
    }
}
