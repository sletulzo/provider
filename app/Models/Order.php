<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use BelongsToTenant;

    protected $table = 'orders';

    protected $casts = [
        'responded_at' => 'datetime',
        'is_sent' => 'boolean',
        'is_accepted' => 'boolean',
        'is_refused' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function lines()
    {
        return $this->hasMany(OrderLine::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
<<<<<<< Updated upstream
=======

    public function isValid()
    {
        return $this->is_sent && $this->is_accepted;
    }

    public function isPending(): bool
    {
        return ! $this->responded_at && ! $this->is_refused && ! $this->is_accepted;
    }

    public function isResponded(): bool
    {
        return (bool) $this->responded_at;
    }

    public function getTotal(): int
    {
        $this->loadMissing('lines.product');

        return $this->lines->sum(fn (OrderLine $line) => $line->getLineTotal());
    }

    public function getAcceptedTotal(): int
    {
        $this->loadMissing('lines.product');

        return $this->lines
            ->where('status', OrderLine::STATUS_ACCEPTED)
            ->sum(fn (OrderLine $line) => $line->getLineTotal());
    }

    public function getStatus(): array
    {
        if ($this->is_refused) {
            return [
                'slug' => 'refused',
                'color' => '#ef4444',
                'label' => 'Refusée',
            ];
        }

        if (! $this->responded_at) {
            if ($this->is_refused) {
                return [
                    'slug' => 'refused',
                    'color' => '#ef4444',
                    'label' => 'Refusée',
                ];
            }

            if ($this->is_accepted) {
                return [
                    'slug' => 'accepted',
                    'color' => '#22c55e',
                    'label' => 'Acceptée',
                ];
            }

            return [
                'slug' => 'waiting',
                'color' => '#64748b',
                'label' => 'En attente',
            ];
        }

        $this->loadMissing('lines');

        $accepted = $this->lines->where('status', OrderLine::STATUS_ACCEPTED)->count();
        $missing = $this->lines->where('status', OrderLine::STATUS_MISSING)->count();
        $total = $this->lines->count();

        if ($accepted === $total && $total > 0) {
            return [
                'slug' => 'accepted',
                'color' => '#22c55e',
                'label' => 'Acceptée',
            ];
        }

        if ($missing === $total && $total > 0) {
            return [
                'slug' => 'refused',
                'color' => '#ef4444',
                'label' => 'Tout indisponible',
            ];
        }

        if ($accepted > 0 && $missing > 0) {
            return [
                'slug' => 'partial',
                'color' => '#f59e0b',
                'label' => 'Partiellement acceptée',
            ];
        }

        return [
            'slug' => 'waiting',
            'color' => '#64748b',
            'label' => 'En attente',
        ];
    }

    public static function findByUuid(string $uuid): ?self
    {
        return static::withoutGlobalScope('tenant')
            ->where('uuid', $uuid)
            ->first();
    }

    public function generateUrl(): string
    {
        return URL::signedRoute('front.commande.show', [
            'uuid' => $this->uuid,
        ]);
    }
>>>>>>> Stashed changes
}
