<?php

namespace App\Filament\Resources\BalanceRequestResource\Pages;

use App\Filament\Resources\BalanceRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBalanceRequest extends EditRecord
{
    protected static string $resource = BalanceRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
