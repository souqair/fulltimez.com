<?php

namespace App\Filament\Saas\Resources\AtsCvPurchaseResource\Pages;

use App\Filament\Saas\Resources\AtsCvPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAtsCvPurchase extends EditRecord
{
    protected static string $resource = AtsCvPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
