<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use BelongsToTenant;
    
    protected $table = 'orders';

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
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    /**
     * Relation
     */
    public function lines()
    {
        return $this->hasMany(OrderLine::class, 'order_id');
    }
    
    /**
     * Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Return boolean if is valid
     */
    public function isValid()
    {
        return $this->is_sent && $this->is_accepted;
    }

    /**
     * Generate url 
     */
    public function generateUrl(): string
    {
        return URL::signedRoute('front.commande.accept', [
            'uuid' => $this->uuid,
        ]);
    }
}
