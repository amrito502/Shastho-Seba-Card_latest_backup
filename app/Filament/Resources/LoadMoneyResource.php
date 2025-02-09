<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\LoadMoney;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Notifications\Notification;
use App\Filament\Resources\LoadMoneyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LoadMoneyResource\RelationManagers;
// use Filament\Forms\Components\Actions\Action;
// use Filament\Tables\Actions\Action;

class LoadMoneyResource extends Resource
{
    protected static ?string $model = LoadMoney::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Deposit Money';
    protected static ?string $modelLabel = 'Deposit Money';
    protected static ?string $navigationGroup = 'Funds Administration';
    protected static ?string $slug = 'load-money';
    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return Auth::user()->role === 'SUPERADMIN'; // Only SUPERADMIN can view transactions
    }

    public static function canViews(): bool
    {
        return Auth::user()->role === 'admin'; // Only SUPERADMIN can create
    }
    public static function canCreate(): bool
    {
        return Auth::user()->role === 'SUPERADMIN'; // Only SUPERADMIN can create
    }

    // load money can edit
    public static function canEdit($record): bool
    {
        return Auth::user()->role === 'SUPERADMIN'; // Only SUPERADMIN can edit
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->role === 'SUPERADMIN'; // Only SUPERADMIN can edit
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Group::make()
                    ->schema([
                        Section::make('Fund Wallet')
                            ->description('Add funds to your account and watch your balance grow!')
                            ->schema([
                                TextInput::make('amount')
                                    ->label('Deposit Amount')
                                    ->required()
                                    ->numeric()
                                    ->default(0.00),
                                Hidden::make('superadmin_id')->default(auth()->id()),
                            ]),

                        // Transfer Button at the Bottom
                        \Filament\Forms\Components\Actions::make([
                            \Filament\Forms\Components\Actions\Action::make('depositmoney')
                                ->label('Deposit Money')
                                ->color('warning')
                                ->requiresConfirmation()
                                ->action(function ($livewire) {
                                    $data = $livewire->form->getState(); // Get the form data
                                    static::depositmoney($data);
                                }),
                        ])->columnSpanFull(),


                    ])
            ]);
    }




    public static function depositmoney($data)
    {
        DB::beginTransaction();

        try {

            $superadminId = Auth::id();
            $superadmin = User::where('id', $superadminId)->where('role', 'SUPERADMIN')->firstOrFail();

            if ($data['amount'] === 0 || !$superadmin) {
                Notification::make()
                ->title('Please Enter Amonut')
                ->danger()
                ->send();
            }
            else
            {
                $superadmin->increment('balance', $data['amount']);
                LoadMoney::create([
                    'superadmin_id' => Auth::id(),
                    'amount' => $data['amount']
                ]);
                Notification::make()
                ->title('Money Deposit Successfully')
                ->success()
                ->send();
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Notification::make()
                ->title('Money Deposit Failed')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }










    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('superadmin.name')->label('SuperAdmin Name')
                    ->toggleable(true)
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
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
                TextColumn::make('amount')
                    ->summarize(
                        [
                            Sum::make()->money('BDT')
                                ->label('Net Deposit Amonut : ')
                        ]
                    )->label('Deposit Amonuts')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListLoadMoney::route('/'),
            'create' => Pages\CreateLoadMoney::route('/create'),
            'view' => Pages\ViewLoadMoney::route('/{record}'),
            'edit' => Pages\EditLoadMoney::route('/{record}/edit'),
        ];
    }
}
