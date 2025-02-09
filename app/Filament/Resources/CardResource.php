<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Card;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CardTransaction;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CardResource\Pages;

class CardResource extends Resource
{
    protected static ?string $model = Card::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Cards';

    public static function canCreate(): bool
    {
        return Auth::user()->role === 'SUPERADMIN'; // Only SUPERADMIN can create
    }

    public static function canEdit($record): bool
    {
        return Auth::user()->role === 'SUPERADMIN'; // Only SUPERADMIN can edit
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Information')
                    ->schema([
                        Select::make('user_id')
                            ->label('Select User')
                            ->relationship('user', 'name')
                            ->required()->searchable(),
                    ]),

                Section::make('Card Details')
                    ->schema([
                        Repeater::make('cards')
                            ->label('Cards')
                            ->schema([
                                TextInput::make('number')
                                    ->label('Number')
                                    ->required()
                                    ->unique()
                                    ->numeric(),
                                Select::make('type')
                                    ->label('Type')
                                    ->options([
                                        'gold' => 'Gold',
                                        'silver' => 'Silver',
                                        'platinum' => 'Platinum',
                                    ])
                                    ->required(),
                                TextInput::make('price')
                                    ->label('Price')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0),
                            ])
                            ->defaultItems(10)
                            ->columns(3),
                    ]),

                // Transfer Button at the Bottom
                \Filament\Forms\Components\Actions::make([
                    \Filament\Forms\Components\Actions\Action::make('transfer')
                        ->label('Send Card to Assigned User')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function ($livewire) {
                            $data = $livewire->form->getState(); // Get the form data
                            static::transferCards($data);
                        }),
                ])->columnSpanFull(),
            ]);
    }

    public static function transferCards(array $data)
    {
        if (empty($data['user_id']) || empty($data['cards'])) {
            Notification::make()
                ->title('Error')
                ->danger()
                ->body('User or cards missing.')
                ->send();
            return;
        }

        $user = User::find($data['user_id']);
        if (!$user || $user->role !== 'admin') {
            Notification::make()
                ->title('Error')
                ->danger()
                ->body('Invalid user selection.')
                ->send();
            return;
        }

        // Count card types
        $cardCounts = ['silver' => 0, 'gold' => 0, 'platinum' => 0];

        foreach ($data['cards'] as $card) {
            if (isset($cardCounts[$card['type']])) {
                $cardCounts[$card['type']]++;
            }
        }

        // Format the data
        $formattedCards = sprintf(
            "Silver = %d, Gold = %d, Platinum = %d, Total = %d",
            $cardCounts['silver'],
            $cardCounts['gold'],
            $cardCounts['platinum'],
            array_sum($cardCounts)
        );

        // Save transaction details
        CardTransaction::create([
            'superadmin_id' => auth()->id(),
            'admin_id' => $user->id,
            'cards' => $formattedCards, // Save as a string
        ]);

        // Assign Cards
        foreach ($data['cards'] as $card) {
            Card::create([
                'user_id' => $user->id,
                'number' => $card['number'],
                'type' => $card['type'],
                'price' => $card['price'],
                'status' => 'Inactive',
            ]);
        }

        Notification::make()
            ->title('Transfer Successful')
            ->success()
            ->body('Cards assigned to the user and transaction saved.')
            ->send();
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->searchable(),
                TextColumn::make('type')->searchable(),
                TextColumn::make('price'),
                TextColumn::make('status'),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'gold' => 'Gold',
                        'silver' => 'Silver',
                        'platinum' => 'Platinum',
                    ])
                    ->default('') // Default filter for 'Gold'
                    ->label('Filter by Type'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()->visible(fn(Card $record) => $record->isAssignedToCurrentUser()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->modifyQueryUsing(function (Builder $query) {
                // Only show cards assigned to the current user
                $query->where('user_id', auth()->id());
            });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCards::route('/'),
            'create' => Pages\CreateCard::route('/create'),
            // 'view' => Pages\ViewCard::route('/{record}'), // Add the view page
            'edit' => Pages\EditCard::route('/{record}/edit'),
        ];
    }
}

