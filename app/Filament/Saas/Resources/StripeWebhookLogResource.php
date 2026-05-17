<?php

namespace App\Filament\Saas\Resources;

use App\Filament\Saas\Resources\StripeWebhookLogResource\Pages;
use App\Models\StripeWebhookLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StripeWebhookLogResource extends Resource
{
    protected static ?string $model = StripeWebhookLog::class;
    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?string $navigationGroup = 'System';
    protected static ?int $navigationSort = 80;
    protected static ?string $label = 'Webhook Log';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('event_id')->disabled(),
            Forms\Components\TextInput::make('type')->disabled(),
            Forms\Components\TextInput::make('status')->disabled(),
            Forms\Components\Textarea::make('error_message')->disabled()->columnSpanFull(),
            Forms\Components\KeyValue::make('payload')->disabled()->columnSpanFull(),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->dateTime('M j, Y H:i:s')->sortable()->label('Received'),
                Tables\Columns\TextColumn::make('type')->badge()->searchable(),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'success' => 'processed', 'danger' => 'failed', 'gray' => fn ($s) => in_array($s, ['received', 'ignored']),
                ]),
                Tables\Columns\TextColumn::make('event_id')->limit(20)->copyable(),
                Tables\Columns\TextColumn::make('error_message')->limit(50)->color('danger'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(['processed' => 'Processed', 'failed' => 'Failed', 'received' => 'Received', 'ignored' => 'Ignored']),
            ])
            ->actions([Tables\Actions\ViewAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStripeWebhookLogs::route('/'),
            'view'  => Pages\ViewStripeWebhookLog::route('/{record}'),
        ];
    }

    public static function canCreate(): bool { return false; }
}
