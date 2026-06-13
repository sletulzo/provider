<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderLine;
use Illuminate\Support\Facades\DB;

class OrderResponseService
{
    public function applyResponse(Order $order, array $lineStatuses, bool $refuseAll = false, ?string $note = null): void
    {
        DB::transaction(function () use ($order, $lineStatuses, $refuseAll, $note) {
            $order->load(['lines.product', 'provider']);

            if ($refuseAll) {
                $this->refuseEntireOrder($order, $note);

                return;
            }

            foreach ($order->lines as $line) {
                $status = $lineStatuses[$line->id] ?? OrderLine::STATUS_MISSING;

                if (! in_array($status, [OrderLine::STATUS_ACCEPTED, OrderLine::STATUS_MISSING], true)) {
                    $status = OrderLine::STATUS_MISSING;
                }

                $previousStatus = $line->status;
                $line->status = $status;
                $line->save();

                if ($status === OrderLine::STATUS_MISSING && $previousStatus !== OrderLine::STATUS_MISSING) {
                    $this->restoreStock($order, $line);
                }
            }

            $order->is_refused = false;
            $order->is_accepted = $order->lines->contains(fn (OrderLine $line) => $line->status === OrderLine::STATUS_ACCEPTED);

            $allMissing = $order->lines->every(fn (OrderLine $line) => $line->status === OrderLine::STATUS_MISSING);
            if ($allMissing && $order->lines->isNotEmpty()) {
                $order->is_refused = true;
                $order->is_accepted = false;
            }

            $order->responded_at = now();
            $order->provider_note = $note;
            $order->save();
        });
    }

    private function refuseEntireOrder(Order $order, ?string $note): void
    {
        foreach ($order->lines as $line) {
            if ($line->status !== OrderLine::STATUS_MISSING) {
                $this->restoreStock($order, $line);
            }

            $line->status = OrderLine::STATUS_MISSING;
            $line->save();
        }

        $order->is_refused = true;
        $order->is_accepted = false;
        $order->responded_at = now();
        $order->provider_note = $note;
        $order->save();
    }

    private function restoreStock(Order $order, OrderLine $line): void
    {
        $provider = $order->provider;

        if (! $provider?->is_stock || ! $line->product) {
            return;
        }

        $line->product->addToStock($line->quantity);
    }
}
