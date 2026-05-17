<?php

namespace App\Filament\Saas\Resources\TransactionResource\Pages;

use App\Filament\Saas\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
}
