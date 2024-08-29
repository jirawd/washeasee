<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = ['service_category_name'];

    public function services() {
        return $this->hasMany(Services::class);
    }

    public function inventory_items() {
        return $this->belongsTo(Services::class);
    }
}
