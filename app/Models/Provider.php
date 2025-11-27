<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use BelongsToTenant;
    
    protected $table = 'providers';

    public function products()
    {
        return $this->hasMany(Product::class, 'provider_id');
    }

    public function orderWaitings()
    {
        return $this->hasMany(OrderWaiting::class, 'provider_id');
    }

    public function sumOrderWaitings()
    {
        return $this->orderWaitings()->sum('quantity');
    }
}
