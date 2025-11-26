<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table = 'tenants';

    /**
     * Users relation
     *
     * @var collection
     */
    public function users()
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
