<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    use HasFactory;

    protected $fillable = ['laundry_shop_id', 'inventory_id', 'transaction_type', 'quantity'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
