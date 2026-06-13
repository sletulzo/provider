<?php

namespace App\Models;

use App\Models\OrderWaiting;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table = 'tenants';

    protected $casts = [
        'smtp_password' => 'encrypted',
    ];

    /**
     * Users relation
     *
     * @var collection
     */
    public function users()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    /**
     * Order waiting relation
     *
     * @var collection
     */
    public function ordersWaiting()
    {
        return $this->hasMany(OrderWaiting::class, 'tenant_id');
    }

    /**
     * Order relation
     *
     * @var collection
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'tenant_id');
    }

    /**
     * Count order waiting
     *
     * @var integer
     */
    public function countOrdersWaiting()
    {
        return $this->ordersWaiting()->count();
    }

    /**
     * Count pending orders awaiting provider response
     *
     * @var integer
     */
    public function countOrders()
    {
        return $this->orders()
            ->whereNull('responded_at')
            ->where('is_refused', false)
            ->where('is_accepted', false)
            ->count();
    }
}
