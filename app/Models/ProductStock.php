<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $table = 'products_stocks';
    protected $fillable = ['product_id', 'quantity'];

    /**
     * Relation
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
