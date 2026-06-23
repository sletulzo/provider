<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderResponseNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class PushNotifier
{
    /**
     * Notifie les utilisateurs « fournisseur » du tenant qu'une commande vient d'être passée.
     */
    public function notifyNewOrder(Order $order): void
    {
        try {
            $providers = User::query()
                ->where('tenant_id', $order->tenant_id)
                ->whereHas('userType', fn ($q) => $q->where('slug', 'provider'))
                ->get();

            if ($providers->isEmpty()) {
                return;
            }

            Notification::send($providers, new NewOrderNotification($order));
        } catch (\Throwable $e) {
            Log::warning('Push (nouvelle commande) non envoyée : ' . $e->getMessage());
        }
    }

    /**
     * Notifie le client qui a passé la commande que le fournisseur a répondu.
     */
    public function notifyOrderResponse(Order $order): void
    {
        try {
            $client = $order->user;

            if (! $client) {
                return;
            }

            $client->notify(new OrderResponseNotification($order));
        } catch (\Throwable $e) {
            Log::warning('Push (réponse commande) non envoyée : ' . $e->getMessage());
        }
    }
}
