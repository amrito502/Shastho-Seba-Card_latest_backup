<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Tables\Table;
use Pages\ViewCardTransaction;
use App\Models\CardTransaction;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\CardTransactionResource\Pages;

class CardTransactionResource extends Resource
{
    protected static ?string $model = CardTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Cards';

    public static function canAccess(): bool
    {
        return Auth::user()->role === 'SUPERADMIN'; // Only SUPERADMIN can view transactions
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('superadmin.name')->label('Sent By')->searchable(),
                TextColumn::make('admin.name')->label('Sent To')->searchable(),
                TextColumn::make('cards')->label('Cards')->sortable(),
                TextColumn::make('created_at')->label('Date')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCardTransactions::route('/'),
            // 'view' => Pages\EditCardTransaction::route('/{record}'),
        ];
    }
}
