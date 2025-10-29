<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $table = 'orders_lines';
    protected $fillable = ['order_id', 'product_id', 'unity_id'];
}
