<?php

namespace App\Filament\Resources\FundTransferResource\Pages;

use App\Filament\Resources\FundTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFundTransfer extends EditRecord
{
    protected static string $resource = FundTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
