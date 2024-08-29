<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class TopCustomers extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table

            ->query(
                // Get the top customers.
                User::select('users.id', 'users.name', 'users.email', DB::raw('count(transactions.id) as transaction_count'))
                    ->join('transactions', 'users.id', '=', 'transactions.customer_id')
                    ->where('users.role', 'customer')
                    ->groupBy('users.id', 'users.name', 'users.email')
                    ->orderBy('transaction_count', 'desc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction_count')
                    ->label('Total Transactions')
                    ->searchable()
                    ->sortable(),
            ])
            ->recordTitle('Top 10 Customers')
            ->description('by Laundry Service Usage');
    }
}
