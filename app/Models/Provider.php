<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Provider extends Model
{
    use BelongsToTenant;
    
    protected $table = 'providers';

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
    public function products()
    {
        return $this->hasMany(Product::class, 'provider_id');
    }

    /**
     * Relation
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'provider_id');
    }

    /**
     * Relation
     */
    public function orderWaitings()
    {
        return $this->hasMany(OrderWaiting::class, 'provider_id');
    }

    /**
     * Most ordered providers
     */
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

    /**
     * Relation
     */
    public function sumOrderWaitings()
    {
        return $this->orderWaitings()->sum('quantity');
    } 

    /**
     * Get default mail content
     */
    public function getMailContent()
    {
        if ($this->email_content)
            return $this->email_content;

        return "Merci !\n". Auth::user()->tenant?->name ." \n" . Auth::user()->tenant?->adress;
    }
    
    /**
     * Get price
     */
    public function getPrice()
    {
        $price = 0;

        foreach($this->orderWaitings as $orderWaiting)
        {
            if ($orderWaiting->product)
            {
                $price += $orderWaiting->quantity * $orderWaiting->product->price;            
            }
        }

        return $price;
    }
}
