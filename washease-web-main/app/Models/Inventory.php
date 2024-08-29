<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['laundry_shop_id', 'item_image', 'item_name', 'item_category', 'item_price', 'item_quantity', 'unit'];

    public function stock()
    {
        return $this->hasMany(Stocks::class);
    }

    public function getMonthlyStockLevels()
    {
        // Get the current year
        $year = Carbon::now()->year;

        // Initialize an array to hold stock levels for each month
        $monthlyStockLevels = array_fill(0, 12, 0);

        // Get all stock transactions for the current year
        $stocks = $this->stock()
            ->whereYear('created_at', $year)
            ->get();

        foreach ($stocks as $stock) {
            // Get the month of the transaction (1 for January, 2 for February, etc.)
            $month = Carbon::parse($stock->created_at)->month;

            // Adjust the stock level based on the transaction type
            if ($stock->transaction_type == 'in') {
                $monthlyStockLevels[$month - 1] += $stock->quantity;
            } elseif ($stock->transaction_type == 'out') {
                $monthlyStockLevels[$month - 1] -= $stock->quantity;
            }
        }

        return $monthlyStockLevels;
    }
}
