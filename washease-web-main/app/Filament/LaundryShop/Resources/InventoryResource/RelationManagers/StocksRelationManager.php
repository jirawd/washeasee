<?php

namespace App\Filament\LaundryShop\Resources\InventoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class StocksRelationManager extends RelationManager
{
    protected static string $relationship = 'stock';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('inventory_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('inventory_id')
            ->columns([
                Tables\Columns\TextColumn::make('inventory.item_name'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('inventory.created_at')
                ->formatStateUsing(fn (string $state) => Carbon::parse($state)->format('M d, Y')),
                Tables\Columns\TextColumn::make('transaction_type')
                ->badge()
                ->color(fn (string $state): string => match ($state){
                    'Stock In' => 'success',
                    'Stock Out' => 'danger',
                }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
