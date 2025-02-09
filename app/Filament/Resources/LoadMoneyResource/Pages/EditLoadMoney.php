<?php

namespace App\Filament\Resources\LoadMoneyResource\Pages;

use App\Filament\Resources\LoadMoneyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLoadMoney extends EditRecord
{
    protected static string $resource = LoadMoneyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
