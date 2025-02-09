<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\LoadMoney;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\FundTransfer;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use App\Models\MoneyTransactionInvoice;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\FundTransferResource\Pages;
use Filament\Forms\Components\Group;
use Filament\Tables\Columns\Summarizers\Sum;

class FundTransferResource extends Resource
{
    protected static ?string $model = FundTransfer::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Payment Transaction';
    protected static ?string $modelLabel = 'Payment Transfer';
    protected static ?string $navigationGroup = 'Funds Administration';
    protected static ?int $navigationSort = 2;

    public static function canViews(): bool
    {
        return Auth::user()->role === 'admin';
    }
    public static function canCreate(): bool
    {
        return Auth::user()->role === 'SUPERADMIN';
    }

    // load money can edit
    public static function canEdit($record): bool
    {
        return Auth::user()->role === 'SUPERADMIN';
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->role === 'SUPERADMIN';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Payment Transaction Informations!')
                            ->description('Input the admin details and specify the transfer amount for processing the fund transaction!')
                            ->schema([
                                Select::make('user_id')
                                    ->label('Select Admin')
                                    ->relationship('user', 'name')
                                    ->required(),
                                TextInput::make('amount')
                                    ->label('Enter Amount')
                                    ->numeric()
                                    ->required()
                                    ->default(0),
                            ])
                    ]),
                Actions::make([
                    Action::make('transferMoney')
                        ->label('Payment Transfer')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function ($livewire) {
                            $data = $livewire->form->getState();
                            static::transferMoney($data);
                        }),
                ])->columnSpanFull(),
            ]);
    }

    public static function transferMoney($data)
    {
        DB::beginTransaction();

        try {
            if (empty($data['user_id']) || empty($data['amount'])) {
                Notification::make()
                    ->title('Error')
                    ->danger()
                    ->body('User or amount is missing.')
                    ->send();
                return;
            }

            $user = User::find($data['user_id']);
            if (!$user || $user->role !== 'admin') {
                throw new \Exception('Invalid user selection.');
            }

            $availableBalance = LoadMoney::sum('amount');
            if ($availableBalance < $data['amount']) {
                throw new \Exception('Insufficient funds available for this transfer.');
            }

            $loadMoney = LoadMoney::first();
            if (!$loadMoney) {
                throw new \Exception('No funds available.');
            }
            $loadMoney->decrement('amount', $data['amount']);


            $superadminId = Auth::id();
            $superadmin = User::where('id', $superadminId)->where('role', 'SUPERADMIN')->firstOrFail();

            $adminId = $data['user_id'];
            $admin = User::where('id', $adminId)->where('role', 'admin')->firstOrFail();

            if (!$superadmin) {
                Notification::make()
                    ->title('No funds available.')
                    ->danger()
                    ->send();
            }else {
                $superadmin->decrement('balance', $data['amount']);
                $admin->increment('balance', $data['amount']);

                FundTransfer::create([
                    'superadmin_id' => Auth::id(),
                    'admin_id' => $data['user_id'],
                    'amount' => $data['amount'],
                ]);
                Notification::make()
                    ->title('Money Sent Successfully')
                    ->success()
                    ->send();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Notification::make()
                ->title('Transaction Failed')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                FundTransfer::query()
                    ->when(auth()->user()->role === 'admin', fn($query) => $query->where('admin_id', auth()->id()))
            )
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->searchable()
                    ->toggleable(true)
                    ->sortable(),
                TextColumn::make('superadmin.name')
                    ->label('Transfer By')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('admin.name')
                    ->label('Transfer To')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction_id')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('amount')
                    ->summarize([
                        Sum::make()->money('BDT')
                            ->label('Total Transaction Money : ')
                    ])->label('Individual Amount')->sortable()->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make(),]),
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFundTransfers::route('/'),
            'create' => Pages\CreateFundTransfer::route('/create'),
            'edit' => Pages\EditFundTransfer::route('/{record}/edit'),
        ];
    }
}
