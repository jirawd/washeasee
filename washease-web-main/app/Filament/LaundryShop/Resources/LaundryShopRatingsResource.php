<?php

namespace App\Filament\LaundryShop\Resources;

use App\Filament\LaundryShop\Resources\LaundryShopRatingsResource\Pages;
use App\Filament\LaundryShop\Resources\LaundryShopRatingsResource\RelationManagers;
use App\Models\LaundryShopRatings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Mokhosh\FilamentRating\Columns\RatingColumn;

class LaundryShopRatingsResource extends Resource
{
    protected static ?string $model = LaundryShopRatings::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('laundry_shop.name'),
                Tables\Columns\TextColumn::make('rating_comment'),
                RatingColumn::make('rating_count')
                    ->label('Rating')
                    ->color('warning'),
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListLaundryShopRatings::route('/'),
//            'create' => Pages\CreateLaundryShopRatings::route('/create'),
//            'edit' => Pages\EditLaundryShopRatings::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('laundry_shop_id', Auth::id());
    }
}
