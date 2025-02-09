<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\District;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SubDistrict;
use App\Models\Organization;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrganizationResource\Pages;
use App\Filament\Resources\OrganizationResource\RelationManagers;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Create a Post')->description('Fill the necessary fields to create a organization...')->collapsible()->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('address')->required(),
                    Select::make('district_id')
                    ->label('District')
                    ->options(District::all()->sortBy('name')->pluck('name', 'id'))
                    ->reactive()->required()
                    ->afterStateUpdated(fn (callable $set) => $set('sub_district_id', null)),
                    Select::make('sub_district_id')
                    ->label('Sub District')->required()
                    ->options(function (callable $get) {
                    $districtId = $get('district_id');
                        if (!$districtId) {
                            return SubDistrict::all()->pluck('name', 'id');
                        }
                        return SubDistrict::where('district_id', $districtId)->pluck('name', 'id');
                    })->reactive(),
                ])->columnSpan(2),

                Section::make('Meta Information')->description('Fill meta info for the organization...')->collapsible()->schema([
                   FileUpload::make('logo')->disk('public')->directory('/images/organizations')->image(),
                   TextInput::make('maxDiscount')->required()->numeric(),
                   TextInput::make('minDiscount')->required()->numeric(),
                ])->columnSpan(1),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                ImageColumn::make('logo'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('address'),
                TextColumn::make('maxDiscount'),
                TextColumn::make('minDiscount'),
                TextColumn::make('district.name')->label('District'),
                TextColumn::make('subDistrict.name')->label('Sub District'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }
}
