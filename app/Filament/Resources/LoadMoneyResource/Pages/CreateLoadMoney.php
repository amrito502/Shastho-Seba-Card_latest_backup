<?php

namespace App\Filament\Resources\LoadMoneyResource\Pages;

use App\Filament\Resources\LoadMoneyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLoadMoney extends CreateRecord
{
    protected static string $resource = LoadMoneyResource::class;
    protected function getFormActions(): array
    {
        return [];
    }
}
