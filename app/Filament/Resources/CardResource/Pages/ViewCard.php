<?php

namespace App\Filament\Resources\CardResource\Pages;

use App\Filament\Resources\CardResource;
use App\Models\Card;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;


class ViewCard extends ViewRecord
{
    protected static string $resource = CardResource::class;

    protected function resolveRecord(int | string $key): Model
    {
        // Fetch the card and ensure it belongs to the current user
        $card = Card::findOrFail($key);

        if ($card->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to view this card.');
        }

        return $card;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getContent(): string
    {
        return <<<HTML
                <div class="space-y-4">
                    <div>
                        <label class="font-bold">Card Number:</label>
                        <p>{$this->record->number}</p>
                    </div>
                    <div>
                        <label class="font-bold">Card Type:</label>
                        <p>{$this->record->type}</p>
                    </div>
                    <div>
                        <label class="font-bold">Price:</label>
                        <p>{$this->record->price}</p>
                    </div>
                    <div>
                        <label class="font-bold">Status:</label>
                        <p>{$this->record->status}</p>
                    </div>
                </div>
                HTML;
    }
}
