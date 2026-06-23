<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class NewOrderNotification extends Notification
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification): WebPushMessage
    {
        $this->order->loadMissing(['provider', 'user', 'lines']);

        $clientName = $this->order->user?->name ?? 'Un client';
        $providerName = $this->order->provider?->name ?? 'un fournisseur';
        $count = $this->order->lines->count();

        return (new WebPushMessage)
            ->title('Nouvelle commande')
            ->body("{$clientName} a passé une commande chez {$providerName} ({$count} article" . ($count > 1 ? 's' : '') . ').')
            ->icon('/icons/app-icon.png')
            ->badge('/icons/app-icon.png')
            ->tag('order-' . $this->order->id)
            ->data(['url' => route('orders.edit', $this->order)]);
    }
}
