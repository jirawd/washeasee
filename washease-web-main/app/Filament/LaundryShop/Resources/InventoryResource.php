<?php

namespace App\Filament\LaundryShop\Resources;

use App\Filament\LaundryShop\Resources\InventoryResource\Pages;
use App\Filament\LaundryShop\Resources\InventoryResource\RelationManagers;
use App\Models\Inventory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Inventory / Selling Items';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('laundry_shop_id')
                    ->default(Auth::id()),
                Forms\Components\TextInput::make('item_name')
                    ->required(),
                Forms\Components\Select::make('item_category')
                    ->options([
                        'Detergent' => 'Detergent',
                        'Fabric Softener' => 'Fabric Softener',
                    ])
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('item_price')
                    ->required(),
                Forms\Components\TextInput::make('item_quantity')
                    ->default(0)
                    ->readOnly(fn (string $operation) => $operation === 'create')
                    ->dehydrated()
                    ->required(),
                Forms\Components\TextInput::make('unit')
                    ->readOnly()
                    ->dehydrated()
                    ->default('ml')
                    ->required(),
                Forms\Components\FileUpload::make('item_image')
                    ->required()
                    ->image(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('item_name'),
                Tables\Columns\TextColumn::make('item_category'),
                Tables\Columns\TextColumn::make('item_price'),
                Tables\Columns\TextColumn::make('item_quantity'),
                Tables\Columns\ImageColumn::make('item_image'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date Created')
                    ->formatStateUsing(function($record){
                        return Carbon::parse($record->created_at)->format('M d, Y');
                    }),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Update')
                    ->formatStateUsing(function($record){
                        return Carbon::parse($record->updated_at)->format('M d, Y');
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            RelationManagers\StocksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventories::route('/'),
//            'create' => Pages\CreateInventory::route('/create'),
            'view' => Pages\ViewInventory::route('/{record}'),
//            'edit' => Pages\EditInventory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('laundry_shop_id', Auth::id());
    }
}
