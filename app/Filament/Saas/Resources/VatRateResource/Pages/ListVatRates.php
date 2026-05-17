<?php

namespace App\Filament\Saas\Resources\VatRateResource\Pages;

use App\Filament\Saas\Resources\VatRateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVatRates extends ListRecords
{
    protected static string $resource = VatRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
