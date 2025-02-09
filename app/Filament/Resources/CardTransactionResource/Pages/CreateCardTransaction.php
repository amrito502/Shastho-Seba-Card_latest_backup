<?php

namespace App\Filament\Resources\CardTransactionResource\Pages;

use App\Filament\Resources\CardTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCardTransaction extends CreateRecord
{
    protected static string $resource = CardTransactionResource::class;
}
