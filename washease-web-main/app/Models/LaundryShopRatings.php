<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stripe\Customer;

class LaundryShopRatings extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'services_id', 'laundry_shop_id', 'rating_count', 'rating_comment'];

    public function laundry_shop() {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
