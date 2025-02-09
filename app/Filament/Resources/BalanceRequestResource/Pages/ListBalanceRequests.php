<?php

namespace App\Filament\Resources\BalanceRequestResource\Pages;

use App\Filament\Resources\BalanceRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBalanceRequests extends ListRecords
{
    protected static string $resource = BalanceRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
