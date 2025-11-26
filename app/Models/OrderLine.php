<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use BelongsToTenant;
    
    protected $table = 'orders_lines';
    protected $fillable = ['order_id', 'product_id', 'unity_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unity()
    {
        return $this->belongsTo(Unity::class, 'unity_id');
    }
}
