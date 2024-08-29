<?php

namespace App\Filament\LaundryShop\Resources;

use App\Filament\LaundryShop\Resources\RiderResource\Pages;
use App\Filament\LaundryShop\Resources\RiderResource\RelationManagers;
use App\Models\User;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RiderResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Riders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('laundry_shop_rider_id')
                    ->default(Auth::id()),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('email')
                    ->required(),
                TextInput::make('password')
                    ->required(),
                TextInput::make('address')
                    ->required(),
                TextInput::make('phone_number')
                    ->required(),
                Hidden::make('role')
                    ->default('Rider'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('phone_number')
                    ->placeholder('No Phone Number'),
                TextColumn::make('email'),
                TextColumn::make('address'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiders::route('/'),
//            'create' => Pages\CreateRider::route('/create'),
//            'view' => Pages\ViewRider::route('/{record}'),
//            'edit' => Pages\EditRider::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'Rider');
    }
}
