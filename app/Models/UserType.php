<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = 'users_types';

    /**
     * Return customer user type
     */
    public static function customer()
    {
        return self::where('slug', 'customer')->first();
    }
}
