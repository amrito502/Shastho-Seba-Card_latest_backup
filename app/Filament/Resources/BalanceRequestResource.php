<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\BalanceRequest;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BalanceRequestResource\Pages;
use App\Filament\Resources\BalanceRequestResource\RelationManagers;


class BalanceRequestResource extends Resource
{
    protected static ?string $model = BalanceRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Balance Requests';

    protected static ?string $navigationGroup = 'Funds Administration';
    protected static ?int $navigationSort = 3;

    public static function canCreate(): bool
    {
        return Auth::user()->role === 'admin'; // Only Admins can create
    }

    public static function canEdit($record): bool
    {
        return Auth::user()->role === 'SUPERADMIN'; // Only Superadmin can edit
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->role === 'SUPERADMIN'; // Only Superadmin can delete
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('approved_by')
                    ->label('Select Superadmin')
                    ->relationship('approvedBy', 'name', function ($query) {
                        return $query->where('role', 'SUPERADMIN'); // Show only Superadmins
                    })
                    ->required(),
                TextInput::make('amount')
                    ->label('Request Amount')
                    ->numeric()
                    ->required(),
                // Hidden::make('superadmin_id')->default(auth()->id()),
                Hidden::make('admin_id')->default(auth()->id()),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->query(BalanceRequest::query()->when(Auth::user()->role === 'admin', fn($q) => $q->where('admin_id', Auth::id())))
            ->columns([
                TextColumn::make('admin.name')->label('Requested By')->sortable(),
                TextColumn::make('amount')->label('Amount')->money('BDT')->sortable(),
                BadgeColumn::make('status')->colors([
                    'warning' => 'pending',
                    'success' => 'approved',
                    'danger' => 'rejected',
                ]),
                Tables\Columns\TextColumn::make('approvedBy.name')->label('Approved By')->sortable()->default('-'),
                Tables\Columns\TextColumn::make('created_at')->label('Requested At')->dateTime(),
            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->visible(fn($record) => Auth::user()->role === 'SUPERADMIN' && $record->status === 'pending')
                    ->action(function ($record) {
                        $superadmin = Auth::user(); // Get the logged-in superadmin

                        // Ensure Superadmin has enough balance before approving
                        if ($superadmin->balance < $record->amount) {
                            \Filament\Notifications\Notification::make()
                                ->title('Insufficient Balance')
                                ->body('You do not have enough balance to approve this request.')
                                ->danger()
                                ->send();
                            return;
                        }

                        // Deduct balance from Superadmin
                        $superadmin->decrement('balance', $record->amount);

                        // Update the balance request status
                        $record->update([
                            'status' => 'approved',
                            'approved_by' => $superadmin->id,
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->title('Balance Request Approved')
                            ->body('You have successfully approved the balance request.')
                            ->success()
                            ->send();
                    })
                    ->color('success'),

                Action::make('reject')
                    ->label('Reject')
                    ->visible(fn($record) => Auth::user()->role === 'SUPERADMIN' && $record->status === 'pending')
                    ->action(fn($record) => $record->update(['status' => 'rejected']))
                    ->color('danger'),
            ]);
    }






    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBalanceRequests::route('/'),
            'create' => Pages\CreateBalanceRequest::route('/create'),
        ];
    }
}
