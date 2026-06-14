<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderWaiting extends Model
{
    use BelongsToTenant;
    
    protected $table = 'orders_waiting';
    protected $fillable = ['user_id', 'product_id', 'unity_id', 'provider_id'];

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

    /**
     * Relation
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function scopeForUserCart(Builder $query, User $user): Builder
    {
        if ($user->managesOwnCart()) {
            return $query->where('user_id', $user->id);
        }

        return $query->whereNull('user_id');
    }

    public static function findOrCreateForCart(int $productId, int $providerId): self
    {
        $user = auth()->user();

        $query = self::query()
            ->where('product_id', $productId)
            ->where('provider_id', $providerId);

        if ($user->managesOwnCart()) {
            $query->where('user_id', $user->id);
        } else {
            $query->whereNull('user_id');
        }

        $orderWaiting = $query->first();

        if ($orderWaiting) {
            return $orderWaiting;
        }

        $orderWaiting = new self([
            'product_id' => $productId,
            'provider_id' => $providerId,
            'user_id' => $user->managesOwnCart() ? $user->id : null,
        ]);
        $orderWaiting->save();

        return $orderWaiting;
    }
    
    /**
     * Get price
     */
    public function getPrice()
    {
        if ($this->product)
            return $this->product->price * $this->quantity;

        return 0;
    }

    public static function getFormattedEmail()
    {
        $data = [];

        $query = self::join('products', 'products.id', '=', 'orders_waiting.product_id')
            ->leftJoin('unities', 'unities.id', '=', 'orders_waiting.unity_id')
            ->join('providers', 'providers.id', '=', 'orders_waiting.provider_id')
            ->select([
                'orders_waiting.id',
                'orders_waiting.quantity',
                'products.name as product_name',
                'unities.name as unity_name',
                'providers.id as provider_id',
                'providers.name as provider_name',
                'providers.email as provider_email',
                'providers.phone as provider_phone',
                'providers.email_content as provider_email_content',
            ]);


        foreach($query->get() as $datum)
        {
            if (!isset($data[$datum->provider_id]))
            {
                $data[$datum->provider_id] = [
                    'id' => $datum->provider_id,
                    'name' => $datum->provider_name,
                    'email' => $datum->provider_email,
                    'email_content' => $datum->provider_email_content,
                    'items' => []
                ];
            }

            $data[$datum->provider_id]['items'][$datum->id]['quantity'] = $datum->quantity;
            $data[$datum->provider_id]['items'][$datum->id]['product'] = $datum->product_name;
            $data[$datum->provider_id]['items'][$datum->id]['unity'] = $datum->unity_name;
            $data[$datum->provider_id]['items'][$datum->id]['provider'] = $datum->provider;
        }

        return $data;
    }
}
