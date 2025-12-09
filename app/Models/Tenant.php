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
     * Users relation
     *
     * @var collection
     */
    public function orders()
    {
        return $this->hasMany(OrderWaiting::class, 'tenant_id');
    }

    /**
     * Count order waiting
     *
     * @var integer
     */
    public function countOrders()
    {
        return $this->orders()->count();
    }
}
