<?php

namespace App\Filament\Resources\LoadMoneyResource\Pages;

use App\Filament\Resources\LoadMoneyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLoadMoney extends ViewRecord
{
    protected static string $resource = LoadMoneyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
