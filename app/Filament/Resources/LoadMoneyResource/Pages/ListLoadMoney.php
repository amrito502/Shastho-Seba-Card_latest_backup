<?php

namespace App\Filament\Resources\LoadMoneyResource\Pages;

use App\Filament\Resources\LoadMoneyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoadMoney extends ListRecords
{
    protected static string $resource = LoadMoneyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
