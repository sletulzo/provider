<?php

namespace App\Models;

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
}
