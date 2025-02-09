<?php

namespace App\Filament\Resources\CardTransactionResource\Pages;

use App\Filament\Resources\CardTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCardTransaction extends EditRecord
{
    protected static string $resource = CardTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
