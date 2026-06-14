<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Provider extends Model
{
    use BelongsToTenant;

    protected $table = 'providers';

    protected $casts = [
        'prices_updated_at' => 'datetime',
        'is_stock' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Provider $provider) {
            if (empty($provider->uuid)) {
                $provider->uuid = (string) Str::uuid();
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'provider_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'provider_id');
    }

    public function orderWaitings()
    {
        return $this->hasMany(OrderWaiting::class, 'provider_id');
    }

    public static function popular(int $limit = 8, ?int $userId = null)
    {
        return self::query()
            ->withCount(['orders' => function ($query) use ($userId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                }
            }])
            ->orderByDesc('orders_count')
            ->orderBy('name')
            ->limit($limit);
    }

    public function sumOrderWaitings()
    {
        return $this->orderWaitings()->sum('quantity');
    }

    public function getMailContent()
    {
        if ($this->email_content) {
            return $this->email_content;
        }

        return "Merci !\n". Auth::user()->tenant?->name ." \n" . Auth::user()->tenant?->adress;
    }

    public function getPrice()
    {
        $price = 0;

        foreach ($this->orderWaitings as $orderWaiting) {
            if ($orderWaiting->product) {
                $price += $orderWaiting->quantity * $orderWaiting->product->price;
            }
        }

        return $price;
    }

    public static function findByUuid(string $uuid): ?self
    {
        return static::withoutGlobalScope('tenant')
            ->where('uuid', $uuid)
            ->first();
    }

    public function generatePricesUrl(): string
    {
        return URL::temporarySignedRoute('front.tarifs.show', now()->addDays(30), [
            'uuid' => $this->uuid,
        ]);
    }

    public function generatePricesSubmitUrl(): string
    {
        return URL::temporarySignedRoute('front.tarifs.submit', now()->addDays(30), [
            'uuid' => $this->uuid,
        ]);
    }
}
