<?php

namespace App\Filament\LaundryShop\Resources;

use App\Filament\LaundryShop\Resources\ServicesResource\Pages;
use App\Filament\LaundryShop\Resources\ServicesResource\RelationManagers;
use App\Models\ServiceCategory;
use App\Models\Services;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

class ServicesResource extends Resource
{
    protected static ?string $model = Services::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('service_category_id')
                    ->label('Service Category')
                    ->options(ServiceCategory::all()->pluck('service_category_name', 'id'))
                    ->native(false),
                Forms\Components\Hidden::make('laundry_shop_id')
                    ->default(Auth::id())
                    ->dehydrated(true),
                Forms\Components\TextInput::make('service_name')
                ->required(),
                Forms\Components\Textarea::make('description')
                ->required(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric(),

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service_category.service_category_name')
                ->badge(),
                Tables\Columns\TextColumn::make('service_name'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('price')
                ->formatStateUsing(function ($record) {
                    return Number::currency($record->price, 'PHP');
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListServices::route('/'),
//            'create' => Pages\CreateServices::route('/create'),
            'view' => Pages\ViewServices::route('/{record}'),
//            'edit' => Pages\EditServices::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('laundry_shop_id', Auth::id());
    }
}
