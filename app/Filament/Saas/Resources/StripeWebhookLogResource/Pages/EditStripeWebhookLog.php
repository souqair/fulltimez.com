<?php

namespace App\Filament\Saas\Resources\StripeWebhookLogResource\Pages;

use App\Filament\Saas\Resources\StripeWebhookLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStripeWebhookLog extends EditRecord
{
    protected static string $resource = StripeWebhookLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
