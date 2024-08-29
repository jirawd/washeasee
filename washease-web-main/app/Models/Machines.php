<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machines extends Model
{
    use HasFactory;

    protected $fillable = ['laundry_shop_id', 'machine_type', 'machine_name', 'notes', 'status'];
}
