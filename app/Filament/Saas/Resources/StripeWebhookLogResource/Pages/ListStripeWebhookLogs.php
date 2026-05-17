<?php

namespace App\Filament\Saas\Resources\StripeWebhookLogResource\Pages;

use App\Filament\Saas\Resources\StripeWebhookLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStripeWebhookLogs extends ListRecords
{
    protected static string $resource = StripeWebhookLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
