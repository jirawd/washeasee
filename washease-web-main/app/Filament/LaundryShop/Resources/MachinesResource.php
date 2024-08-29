<?php

namespace App\Filament\LaundryShop\Resources;

use App\Filament\LaundryShop\Resources\MachinesResource\Pages;
use App\Filament\LaundryShop\Resources\MachinesResource\RelationManagers;
use App\Models\Machines;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MachinesResource extends Resource
{
    protected static ?string $model = Machines::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('laundry_shop_id')
                ->default(Auth::id()),
                Forms\Components\Select::make('machine_type')
                    ->native(false)
                    ->options([
                        'Drying Machine' => 'Drying Machine',
                        'Washing Machine' => 'Washing Machine'
                    ]),
                Forms\Components\TextInput::make('machine_name'),
                Forms\Components\Textarea::make('notes'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->native(false)
                    ->options([
                        'Reserve' => 'Reserve',
                        'Available' => 'Available',
                        'Not Available' => 'Not Available'
                    ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('machine_type'),
                Tables\Columns\TextColumn::make('machine_name'),
                Tables\Columns\TextColumn::make('notes'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Reserve' => 'gray',
                        'Available' => 'success',
                        'Not Available' => 'danger',
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
            ])->poll('5s');
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
            'index' => Pages\ListMachines::route('/'),
//            'create' => Pages\CreateMachines::route('/create'),
            'view' => Pages\ViewMachines::route('/{record}'),
//            'edit' => Pages\EditMachines::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('laundry_shop_id', Auth::id());
    }
}
