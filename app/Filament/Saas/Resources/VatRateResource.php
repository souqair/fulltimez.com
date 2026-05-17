<?php

namespace App\Filament\Saas\Resources;

use App\Filament\Saas\Resources\VatRateResource\Pages;
use App\Models\VatRate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VatRateResource extends Resource
{
    protected static ?string $model = VatRate::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Billing';
    protected static ?int $navigationSort = 20;
    protected static ?string $label = 'VAT Rate';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('country_key')
                ->helperText('Subdomain key (pk, ae, sa, global)')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(20),
            Forms\Components\TextInput::make('country_name')->required(),
            Forms\Components\TextInput::make('label')->default('VAT')->required(),
            Forms\Components\TextInput::make('rate')->numeric()->required()->suffix('%')->step(0.001),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('stripe_tax_rate_id')->disabled(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country_key')->badge()->sortable(),
                Tables\Columns\TextColumn::make('country_name')->searchable(),
                Tables\Columns\TextColumn::make('label'),
                Tables\Columns\TextColumn::make('rate')->suffix(' %')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('stripe_tax_rate_id')->label('Stripe')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListVatRates::route('/'),
            'create' => Pages\CreateVatRate::route('/create'),
            'edit'   => Pages\EditVatRate::route('/{record}/edit'),
        ];
    }
}
