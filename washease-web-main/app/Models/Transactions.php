<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'laundry_shop_id', 'rider_id', 'service_id', 'machine_id', 'service_type', 'customer_name', 'customer_address', 'customer_type', 'delivery_fee', 'service_avail', 'kilo', 'payment_status', 'payment_method', 'status', 'total_bill','delivery_date'];

    protected $casts = [
        'service_avail' => 'json',
    ];

    public function customer() {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function machines() {
        return $this->belongsTo(Machines::class, 'machine_id', 'id');
    }

}
