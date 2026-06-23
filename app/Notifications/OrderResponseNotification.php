<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class OrderResponseNotification extends Notification
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification): WebPushMessage
    {
        $this->order->loadMissing(['provider', 'lines']);

        $providerName = $this->order->provider?->name ?? 'le fournisseur';
        $status = $this->order->getStatus();

        return (new WebPushMessage)
            ->title('Réponse à votre commande')
            ->body("Votre commande chez {$providerName} : {$status['label']}.")
            ->icon('/icons/logo-transparent.png')
            ->tag('order-response-' . $this->order->id)
            ->data(['url' => route('orders.edit', $this->order)]);
    }
}
