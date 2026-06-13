<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Collection;

class ProviderDashboardService
{
    public function __construct(private User $user) {}

    public function getStats(): array
    {
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();
        $previousStart = now()->subMonth()->startOfMonth();
        $previousEnd = now()->subMonth()->endOfMonth();

        $ordersThisMonth = Order::query()
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->count();

        $ordersPreviousMonth = Order::query()
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->count();

        $pendingOrders = Order::query()
            ->whereNull('responded_at')
            ->where('is_refused', false)
            ->where('is_accepted', false)
            ->count();

        return [
            'orders_this_month' => $ordersThisMonth,
            'orders_previous_month' => $ordersPreviousMonth,
            'orders_evolution' => $this->evolutionPercentage($ordersThisMonth, $ordersPreviousMonth),
            'orders_pending' => $pendingOrders,
            'monthly_revenue' => $this->getMonthlyRevenue(),
            'products_count' => Product::query()->count(),
            'clients_count' => $this->getClientsCount(),
        ];
    }

    public function getPendingOrders(int $limit = 5): Collection
    {
        return Order::query()
            ->whereNull('responded_at')
            ->where('is_refused', false)
            ->where('is_accepted', false)
            ->with(['user', 'lines.product'])
            ->withCount('lines')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    public function getPopularProducts(int $limit = 4): Collection
    {
        return Product::popular($limit)->with('provider')->get();
    }

    private function getMonthlyRevenue(): int
    {
        return Order::query()
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->with(['lines.product'])
            ->get()
            ->sum(fn (Order $order) => $order->getTotal());
    }

    private function getClientsCount(): int
    {
        $customerType = UserType::customer();

        if (! $customerType) {
            return 0;
        }

        return User::query()
            ->where('user_type_id', $customerType->id)
            ->where('id', '!=', $this->user->id)
            ->count();
    }

    private function evolutionPercentage(int $current, int $previous): float
    {
        if ($previous === 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }
}
