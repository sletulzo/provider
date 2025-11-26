<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Unity extends Model
{
    use BelongsToTenant;
    
    protected $table = 'unities';
}
