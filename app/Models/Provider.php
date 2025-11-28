<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use BelongsToTenant;
    
    protected $table = 'providers';

    /**
     * Relation
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
    
    /**
     * Relation
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'provider_id');
    }

    /**
     * Relation
     */
    public function orderWaitings()
    {
        return $this->hasMany(OrderWaiting::class, 'provider_id');
    }

    /**
     * Relation
     */
    public function sumOrderWaitings()
    {
        return $this->orderWaitings()->sum('quantity');
    }
}
