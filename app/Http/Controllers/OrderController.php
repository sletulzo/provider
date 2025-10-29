<?php

namespace App\Http\Controllers;

use App\Models\OrderWaiting;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Provider;
use App\Mail\ProviderEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display provider view
     */
    public function save(Provider $provider, Request $request)
    {
        // Transform to order
        $orderWaiting = OrderWaiting::where('provider_id', $provider->id)->get();

        $order = new Order();
        $order->uuid = Str::uuid()->toString();
        $order->provider_id = $provider->id;
        $order->save();

        foreach($orderWaiting as $item)
        {
            $orderLine = OrderLine::firstOrCreate([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'unity_id' => $item->unity_id,
            ]);

            $orderLine->quantity = $item->quantity;
            $orderLine->update();
            $item->delete();
        }

        $data = [
            'subject' => $request->subject,
            'content' => $request->email_content
        ];

        Mail::to('sletulzo@gmail.com')->send(new ProviderEmail($data));

        return Redirect::route('dashboard')->with('status', 'email-sent');
    }
}
