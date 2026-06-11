<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderWaiting;
use App\Models\Product;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Support\Collection;

class CustomerDashboardService
{
    public function __construct(private User $user) {}

    public function getStats(): array
    {
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();

        $ordersThisMonth = (clone $this->ordersQuery())
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->count();

        $cartItems = (int) OrderWaiting::query()->where('quantity', '>', 0)->sum('quantity');
        $cartProviders = (int) OrderWaiting::query()
            ->where('quantity', '>', 0)
            ->distinct()
            ->count('provider_id');

        return [
            'orders_this_month' => $ordersThisMonth,
            'orders_evolution' => $this->user->getOrdersEvolutionPercentage(),
            'orders_previous_month' => $this->user->getOrdersPreviousMonth(),
            'cart_items' => $cartItems,
            'cart_providers' => $cartProviders,
            'monthly_spend' => $this->getMonthlySpend(),
        ];
    }

    public function getDraftCarts(): Collection
    {
        return OrderWaiting::query()
            ->where('quantity', '>', 0)
            ->with(['provider', 'product'])
            ->get()
            ->groupBy('provider_id')
            ->map(function (Collection $items) {
                $provider = $items->first()->provider;

                return [
                    'provider' => $provider,
                    'items_count' => $items->sum('quantity'),
                    'total' => $items->sum(fn (OrderWaiting $item) => $item->getPrice()),
                ];
            })
            ->filter(fn (array $cart) => $cart['provider'] !== null)
            ->values();
    }

    public function getPopularProducts(int $limit = 4): Collection
    {
        return Product::popular($limit)->with('provider')->get();
    }

    public function getPopularProviders(int $limit = 8): Collection
    {
        $userId = $this->user->is_only_order ? $this->user->id : null;

        return Provider::popular($limit, $userId)->get();
    }

    private function ordersQuery()
    {
        $query = Order::query();

        if ($this->user->is_only_order) {
            $query->where('user_id', $this->user->id);
        }

        return $query;
    }

    private function getMonthlySpend(): int
    {
        return (clone $this->ordersQuery())
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->with(['lines.product'])
            ->get()
            ->sum(fn (Order $order) => $order->getTotal());
    }
}
