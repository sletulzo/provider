<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public function lines()
    {
        return $this->hasMany(OrderLine::class, 'order_id');
    }
}
