<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use BelongsToTenant;
    
    protected $table = 'orders';

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function lines()
    {
        return $this->hasMany(OrderLine::class, 'order_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
