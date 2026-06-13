<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use BelongsToTenant;

    public const STATUS_PENDING = 'pending';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_MISSING = 'missing';

    protected $table = 'orders_lines';
    protected $fillable = ['order_id', 'product_id', 'unity_id', 'quantity', 'status'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unity()
    {
        return $this->belongsTo(Unity::class, 'unity_id');
    }

    public function getLineTotal(): int
    {
        return ($this->product?->price ?? 0) * ($this->quantity ?? 0);
    }

    public function getStatus(): array
    {
        return match ($this->status) {
            self::STATUS_ACCEPTED => [
                'slug' => 'accepted',
                'label' => 'Disponible',
            ],
            self::STATUS_MISSING => [
                'slug' => 'missing',
                'label' => 'Manquant',
            ],
            default => [
                'slug' => 'waiting',
                'label' => 'En attente',
            ],
        };
    }
}
