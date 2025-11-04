<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function lines()
    {
        return $this->hasMany(OrderLine::class, 'order_id');
    }
}
