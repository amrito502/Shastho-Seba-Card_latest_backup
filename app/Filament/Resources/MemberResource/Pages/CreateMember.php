<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Models\Card;
use Filament\Actions;
use App\Filament\Resources\MemberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMember extends CreateRecord
{
    protected static string $resource = MemberResource::class;

    protected function beforeSave(): void
    {
        parent::beforeSave();

        // Get the card_id from the form
        $cardId = $this->data['card_id'] ?? null;

        if ($cardId) {
            // Update the status of the card to Active
            Card::where('id', $cardId)->update(['status' => 'Active']);
        }
    }
}
