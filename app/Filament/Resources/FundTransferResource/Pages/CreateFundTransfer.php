<?php

namespace App\Filament\Resources\FundTransferResource\Pages;

use App\Filament\Resources\FundTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFundTransfer extends CreateRecord
{
    protected static string $resource = FundTransferResource::class;

    protected function getFormActions(): array
    {
        return [];
    }
}
