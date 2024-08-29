<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $fillable = ['service_category_id', 'laundry_shop_id', 'service_name', 'description', 'price'];

    public function service_category() {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function laundry_shop() {
        return $this->belongsTo(User::class);
    }
}
