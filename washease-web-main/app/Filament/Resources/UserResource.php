<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Hugomyb\FilamentMediaAction\Tables\Actions\MediaAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Laundry Shops';
    protected static ?string $navigationGroup = 'Users Module';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->unique(ignoreRecord: true)
                    ->email()
                    ->autocomplete('new-email')
                    ->required(),

                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->autocomplete('new-password')
                    ->required(fn(string $operation): bool => $operation === 'create'),

                Forms\Components\Select::make('role')
                    ->label('Role')
                    ->options([
                        'Administrator' => 'Administrator',
                        'Staff' => 'Staff',
                        'Rider' => 'Rider',
                        'Customer' => 'Customer',
                    ])
                    ->native(false)
                    ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn($record) => match ($record->role) {
                        'Administrator' => 'primary',
                        'Staff' => 'danger',
                        'Rider' => 'success',
                        'Customer' => 'warning',
                        'LaundryShop' => 'info',
                    }),


                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn($record) => match ($record->status) {
                        'PENDING' => 'warning',
                        'APPROVE' => 'success',
                        'REJECTED' => 'danger',
                        'DEACTIVATED' => 'danger'
                    }),

            ])
            ->filters([
                //
            ])
            ->actions([


                MediaAction::make('laundry_shop_permit')
                    ->iconButton()
                    ->icon('heroicon-o-video-camera')
                    ->media(function ($record){
                        return $record->laundry_shop_permit;
                    }),

//                Tables\Actions\ViewAction::make(),
//                Tables\Actions\EditAction::make()
//                    ->mutateFormDataUsing(function ($data) {
//                        if ($data['password'] === null) {
//                            unset($data['password']);
//                        } else {
//                            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
//                        }
//
//                        return $data;
//                    }),


                Tables\Actions\Action::make('Approve')
                    ->requiresConfirmation()
                    ->color('success')
                    ->hidden(fn (User $user) => $user->status === 'APPROVE' && $user->role === 'LaundryShop' || $user->role === 'Customer'|| $user->role === 'Rider')
                    ->action(function (array $data, User $user) {
                        $user->status = 'APPROVE';
                        $user->save();

                        return $data;
                    }),

                Tables\Actions\Action::make('Reject')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->hidden(fn (User $user) => $user->status === 'APPROVE' && $user->role === 'LaundryShop' || $user->role === 'Customer'|| $user->role === 'Rider')
                    ->action(function ($data,  User $user) {
                        $user->status = 'REJECTED';
                        $user->save();
                        return $data;
                    }),

                Tables\Actions\Action::make('Deactivate')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->visible(fn (User $user) => $user->status === 'APPROVE' && $user->role === 'LaundryShop')
                    ->action(function ($data,  User $user) {
                        $user->status = 'DEACTIVATED';
                        $user->save();
                        return $data;
                    }),
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
            'index' => Pages\ListUsers::route('/'),
//            'create' => Pages\CreateUser::route('/create'),
//            'view' => Pages\ViewUser::route('/{record}'),
//            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'LaundryShop');
    }
}
