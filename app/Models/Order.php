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
     * Get status of order
     */
    public function getStatus()
    {
        if ($this->is_refused)
        {
            return [
                'slug' => 'refused',
                'color' => '#db4d2b',
                'label' => 'Refusé'
            ];
        }

        if ($this->is_accepted)
        {
            return [
                'slug' => 'accepted',
                'color' => '#44beee',
                'label' => 'Accepté'
            ];
        }

        return [
            'slug' => 'waiting',
            'color' => '#6f6c6c',
            'label' => 'En attente'
        ];
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
