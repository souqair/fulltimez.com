<?php

namespace App\Filament\Saas\Resources\VatRateResource\Pages;

use App\Filament\Saas\Resources\VatRateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVatRate extends EditRecord
{
    protected static string $resource = VatRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
