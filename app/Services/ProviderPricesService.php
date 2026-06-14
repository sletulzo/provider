<?php

namespace App\Services;

use App\Mail\ProviderPricesUpdatedMail;
use App\Models\Product;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProviderPricesService
{
    public function getCatalogProducts(Provider $provider)
    {
        return Product::withoutGlobalScope('tenant')
            ->where('provider_id', $provider->id)
            ->where('tenant_id', $provider->tenant_id)
            ->with('unity')
            ->orderBy('name')
            ->get();
    }

    /**
     * @return array<int, array{name: string, old: ?int, new: int}>
     */
    public function updatePrices(Provider $provider, array $prices): array
    {
        $changes = [];

        foreach ($prices as $productId => $rawPrice) {
            if ($rawPrice === null || $rawPrice === '') {
                continue;
            }

            $normalized = str_replace(',', '.', trim((string) $rawPrice));

            if ($normalized === '' || ! is_numeric($normalized)) {
                continue;
            }

            $newPriceCents = (int) round((float) $normalized * 100);

            $product = Product::withoutGlobalScope('tenant')
                ->where('id', $productId)
                ->where('provider_id', $provider->id)
                ->where('tenant_id', $provider->tenant_id)
                ->first();

            if (! $product || $product->price === $newPriceCents) {
                continue;
            }

            $changes[$product->id] = [
                'name' => $product->name,
                'old' => $product->price,
                'new' => $newPriceCents,
            ];

            $product->price = $newPriceCents;
            $product->save();
        }

        if ($changes !== []) {
            $provider->prices_updated_at = now();
            $provider->save();

            $this->notifyAdmins($provider, $changes);
        }

        return $changes;
    }

    protected function notifyAdmins(Provider $provider, array $changes): void
    {
        $provider->loadMissing('tenant');

        $admins = User::query()
            ->where('tenant_id', $provider->tenant_id)
            ->where('is_only_order', false)
            ->whereHas('userType', fn ($query) => $query->where('slug', 'customer'))
            ->whereNotNull('email')
            ->get();

        if ($admins->isEmpty()) {
            return;
        }

        try {
            foreach ($admins as $admin) {
                TenantMailer::send(
                    $provider->tenant,
                    $admin->email,
                    new ProviderPricesUpdatedMail($provider, $changes)
                );
            }
        } catch (\Exception $e) {
            Log::warning('Notification tarifs fournisseur non envoyée : '.$e->getMessage());
        }
    }
}
