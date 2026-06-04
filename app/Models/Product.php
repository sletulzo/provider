<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use BelongsToTenant;
    
    protected $table = 'products';

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
    public function unity()
    {
        return $this->belongsTo(Unity::class, 'unity_id');
    }

    /**
     * Relation
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    /**
     * Stocks
     */
    public function stock()
    {
        return $this->hasOne(ProductStock::class, 'product_id');
    }

    /**
     * Order lines
     */
    public function ordersLines()
    {
        return $this->hasMany(OrderLine::class, 'product_id');
    }

    /**
     * Popular product
     */
    public static function popular(int $limit = 4)
    {
        return self::query()
            ->withCount('ordersLines')
            ->orderByDesc('orders_lines_count')
            ->limit($limit);
    }

    /**
     * Stock
     */
    public function getStock()
    {
        return ProductStock::where('product_id', $this->id)
            ->select('quantity')
            ->value('quantity') ?? 0;
    }

    /**
     * Get stock label
     */
    public function getStockLabel()
    {
        $stock = $this->getStock();

        if ($stock > 10) 
        {
            return [
                'name' => 'En stock',
                'color' => 'green',
                'quantity' => $stock
            ];
        }

        if ($stock > 0)
        {
            return [
                'name' => 'Stock faible',
                'color' => 'orange',
                'quantity' => $stock
            ];
        }

        return [
            'name' => 'Rupture de stock',
            'color' => 'red',
            'quantity' => $stock
        ];
    }

    /**
     * Update stock
     */
    public function removeToStock($quantity)
    {
        $stock = $this->getStock();
        $newStock = $stock - $quantity;

        if ($newStock < 0)
            $newStock = 0;

        ProductStock::updateOrCreate(
            ['product_id' => $this->id],
            ['quantity' => $newStock]
        );
    }

    /**
     * Update stock
     */
    public function addToStock($quantity)
    {
        $stock = $this->getStock();
        $newStock = $stock + $quantity;

        ProductStock::updateOrCreate(
            ['product_id' => $this->id],
            ['quantity' => $newStock]
        );
    }
}
