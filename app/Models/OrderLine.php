<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use BelongsToTenant;
    
    protected $table = 'orders_lines';
    protected $fillable = ['order_id', 'product_id', 'unity_id'];

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
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Relation
     */
    public function unity()
    {
        return $this->belongsTo(Unity::class, 'unity_id');
    }
}
