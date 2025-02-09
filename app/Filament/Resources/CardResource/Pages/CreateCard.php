<?php

namespace App\Filament\Resources\CardResource\Pages;

use Filament\Pages\Actions\Action;
use App\Filament\Resources\CardResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCard extends CreateRecord
{
    protected static string $resource = CardResource::class;

    protected function getFormActions(): array
{
    return [

    ];
}
}
