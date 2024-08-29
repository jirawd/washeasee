<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaundryShopLocations extends Model
{
    use HasFactory;

    protected $fillable = ['laundry_shop_id', 'latitude', 'longitude', 'long_lat_point'];

    public function laundry_location() {
        return $this->belongsTo(User::class, 'laundry_shop_id', 'id');
    }
}
