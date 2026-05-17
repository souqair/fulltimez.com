<?php

namespace App\Filament\Saas\Resources\StripeWebhookLogResource\Pages;

use App\Filament\Saas\Resources\StripeWebhookLogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStripeWebhookLog extends CreateRecord
{
    protected static string $resource = StripeWebhookLogResource::class;
}
