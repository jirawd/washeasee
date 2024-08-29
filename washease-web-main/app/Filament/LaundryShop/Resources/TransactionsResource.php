<?php

namespace App\Filament\LaundryShop\Resources;

use App\Filament\LaundryShop\Resources\TransactionsResource\Pages;
use App\Filament\LaundryShop\Resources\TransactionsResource\RelationManagers;
use App\Models\Machines;
use App\Models\Services;
use App\Models\Transactions;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use LaraZeus\Quantity\Components\Quantity;

class TransactionsResource extends Resource
{
    protected static ?string $model = Transactions::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Order Transactions';
    protected static ?string $navigationGroup = 'Transactions';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('laundry_shop_id')
                    ->default(Auth::id()),


                Wizard::make([
                    Wizard\Step::make('Order')
                        ->schema([
                            Select::make('customer_type')
                                ->options([
                                    'Existing' => 'Existing Customer',
                                    'Walk In' => 'Walk In Customer'
                                ])
                                ->native(false)
                                ->live(),
                            TextInput::make('customer_name')
                                ->visible(fn(Get $get) => $get('customer_type') === 'Walk In'),
                            TextInput::make('customer_address')
                                ->visible(fn(Get $get) => $get('customer_type') === 'Walk In'),
                            Select::make('customer_id')
                                ->label('Select Customer')
                                ->searchable()
                                ->native(false)
                                ->visible(fn(Get $get) => $get('customer_type') === 'Existing')
                                ->options(User::query()->where('role', 'Customer')->pluck('name', 'id')),
                            Select::make('rider_id')
                                ->label('Select Rider (If Available)')
                                ->native(false)
                                ->options(User::query()->where('role', 'Rider')->pluck('name', 'id')),

                            Select::make('machine_id')
                                ->label('Select Machine')
                                ->native(false)
                                ->options(Machines::query()->where('laundry_shop_id',Auth::id())->pluck('machine_name', 'id')),


                            Repeater::make('service_avail')
                                ->label('Services')
                                ->statePath('service_avail')
                                ->schema([
                                    Select::make('service')
                                        ->native(false)
                                        ->live(onBlur: true)
                                        ->options(function () {
                                            $services = Services::query()->where('laundry_shop_id', Auth::id())->get();
                                            $groupedServices = [];

                                            foreach ($services as $service) {
                                                $category = strval($service->service_category->service_category_name);
                                                $groupedServices[$category][$service->id] = $service->service_name;
                                            }

                                            return $groupedServices;
                                        })
                                        ->afterStateUpdated(function (?string $state, ?string $old, Set $set) {
                                            $get_service_price = Services::query()->where('id', $state)->first();
                                            $set('service_price', $get_service_price->price);
                                            $set('service_name', $get_service_price->service_name);
                                        })
                                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                        ->required(),
                                    TextInput::make('service_name')
                                        ->disabled()
                                        ->dehydrated(),
                                    TextInput::make('service_price')
                                        ->disabled()
                                        ->dehydrated(),
                                    Quantity::make('quantity')
                                        ->default(1)
                                        ->minValue(0),

                                ])
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    self::updateTotals($get, $set);
                                })
                                ->live()
                                ->columns(4)
                                ->addActionLabel('Add Service'),

                            Select::make('status')
                                ->native(false)
                                ->options([
                                    'PENDING' => 'PENDING',
                                    'PROCESSING' => 'PROCESSING',
                                    'READY FOR PICKUP' => 'READY FOR PICKUP',
                                    'DELIVERED' => 'DELIVERED',
                                ])->required(),
                            Select::make('payment_status')
                                ->native(false)
                                ->options([
                                    'PAID' => 'PAID',
                                    'UNPAID' => 'UNPAID',
                                ])->required(),
                            Select::make('payment_method')
                                ->native(false)
                                ->options([
                                    'CASH' => 'CASH',
                                    'G-CASH' => 'G-CASH',
                                ])->required(),
                            Radio::make('delivery_fee')
                                ->label('Delivery Service Fee')
                                ->options([
                                    0 => 'Standard Service - ₱0.00',
                                    200 => 'Rush Service - ₱200.00',
                                ])
                                ->live()
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    self::updateTotals($get, $set);
                                }),
                            DatePicker::make('delivery_date')
                                ->label('Delivery Date')
                                ->native(false),
                            TextInput::make('total_bill')
                                ->prefix('₱')
                                ->label('Total Price:')
                                ->helperText('Total bill of service')
                                ->disabled()
                                ->dehydrated(),
                        ])->columnSpanFull(),
                    Wizard\Step::make('Order Summary')
                        ->schema([

                            Placeholder::make('order_summary_status')
                                ->content(fn(Get $get): string => $get('delivery_fee') ?? ''),

                            Placeholder::make('order_summary_payment_method')
                                ->content(fn(Get $get): string => $get('payment_method') ?? ''),

                            Placeholder::make('order_summary_payment_status')
                                ->content(fn(Get $get): string => $get('payment_status') ?? ''),

                            Placeholder::make('order_summary_billing_delivery_fee')
                                ->content(fn(Get $get): string => $get('delivery_fee') ?? ''),

                            Placeholder::make('order_summary_billing_full')
                                ->content(fn(Get $get): string => $get('total_bill') ?? '')

                        ])
                    ->description(''),
                ])
                    ->persistStepInQueryString()
                    ->columnSpanFull(),
            ]);
    }

    public static function updateTotals(Get $get, Set $set): void
    {
        // Retrieve all selected products and remove empty rows
        $selectedProducts = collect($get('service_avail'))->filter(fn($item) => !empty($item['service']) && !empty($item['quantity']));
        // Retrieve prices for all selected products
        $prices = Services::find($selectedProducts->pluck('service'))->pluck('price', 'id');
        $get_delivery_fee = $get('delivery_fee');
        // Calculate total bill for each product
        $selectedProducts->transform(function ($item) use ($prices) {
            $item['total_bill'] = $item['quantity'] * $prices[$item['service']];
            return $item;
        });

        // Now, you can access the total bill for each product like this:
        $selectedProducts->pluck('total_bill');

        // If you want to get the sum of all total bills:
        $totalBill = $selectedProducts->sum('total_bill') + $get_delivery_fee;

        $set('total_bill', $totalBill, );

    }

    // This function updates totals based on the selected products and quantities

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->placeholder('No Customer Name')
                    ->formatStateUsing(function ($state){
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('machines.machine_name')
                    ->label('Machine Name')
                    ->badge(),
//                Tables\Columns\TextColumn::make('machines.machine_type')
//                    ->label('Machine Type')
//                    ->color('info')
//                    ->badge(),
                Tables\Columns\TextColumn::make('delivery_fee')
                    ->formatStateUsing(function ($record) {
                        return Number::currency($record->delivery_fee, 'PHP');
                    }),
                Tables\Columns\TextColumn::make('total_bill')
                    ->formatStateUsing(function ($record) {
                        return Number::currency($record->total_bill, 'PHP');
                    }),
                Tables\Columns\TextColumn::make('payment_badge_status')
                    ->getStateUsing(function ($record) {
                        return $record->payment_status;
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'PAID' => 'success',
                        'UNPAID' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('payment_method')
                    ->badge(),
                Tables\Columns\TextColumn::make('laundry_status')
                    ->getStateUsing(function ($record) {
                        return $record->status;
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'PENDING' => 'warning',
                        'PROCESSING' => 'info',
                        'READY FOR PICKUP' => 'primary',
                        'COMPLETED' => 'success',
                    }),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'PENDING' => 'PENDING',
                        'PROCESSING' => 'PROCESSING',
                        'READY FOR PICKUP' => 'READY FOR PICKUP',
                        'COMPLETED' => 'COMPLETED',
                    ])->afterStateUpdated(function ($record, $state, Machines $machines) {

                        $update_machine = Machines::query()->where('id', $record->machine_id)->first();

                        if($state === 'COMPLETED') {
                            $update_machine->status = 'Available';
                            $update_machine->save();
                        }

                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->slideOver(),
                Tables\Actions\Action::make('set_to_paid')
                    ->icon('heroicon-o-banknotes')
                    ->hidden(fn(Transactions $transactions) => $transactions->payment_status == 'PAID')
                    ->label('Set to Paid')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (array $data, Transactions $transactions, Machines $machines): array {
                        $transactions->payment_status = 'PAID';
                        $transactions->save();

                        Notification::make()
                            ->success()
                            ->title('Order Update')
                            ->body('The order has been Paid.');

                        return $data;
                    }),
//                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('add_kilo')
                    ->label('Laundry Kilo')
                    ->icon('heroicon-o-shopping-bag')
                    ->form([
                        TextInput::make('kilo')
                            ->minValue(0)
                        ->numeric(),
                    ])
                    ->modalWidth('md')
                    ->action(function (array $data, Transactions $transactions): array {
                        $transactions->kilo = $data['kilo'];
                        $transactions->save();

                        Notification::make()
                            ->success()
                            ->title('Order Update')
                            ->body('Laundry Order has been updated');

                        return $data;
                    }),

                Tables\Actions\Action::make('Assign a Rider')
                    ->icon('heroicon-o-truck')
                    ->color('info')
                    ->modal()
                    ->modalWidth('md')
                    ->form([
                        Select::make('rider_id')
                            ->label('Rider')
                            ->native(false)
                            ->searchable()
                            ->options(User::query()->where('role', 'Rider')->pluck('name', 'id'))
                    ])
                    ->action(function (array $data, Transactions $record): void {
                        $record->rider_id = $data['rider_id'];
                        $record->save();
                    })

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->poll('5s');
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
            'index' => Pages\ListTransactions::route('/'),
//            'create' => Pages\CreateTransactions::route('/create'),
//            'view' => Pages\ViewTransactions::route('/{record}'),
//            'edit' => Pages\EditTransactions::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('laundry_shop_id', Auth::id())->orderBy('id', 'DESC');
    }


}
