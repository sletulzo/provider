<?php

namespace App\Http\Controllers;

use App\Models\OrderWaiting;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Provider;
use App\Mail\ProviderEmail;
use App\Services\TenantMailer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class OrderController extends Controller
{
    /**
     * Display provider view
     */
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('order.index', compact('orders'));
    }

    /**
     * Display products
     */
    public function products(Order $order)
    {
        return view('order.products', compact('order'));
    }

    /**
     * Accept provider order
     */
    public function accept(Request $request)
    {
        $order = Order::where('uuid', $request->uuid)->firstOrFail();
        $order->is_accepted = true;
        $order->update();

        return view('front.accept', ['order' => $order]);
    }

    /**
     * Delete order
     */
    public function delete(Order $order)
    {
        foreach($order->lines as $line)
        {
            $line->delete();
        }

        $order->delete();

        return Redirect::route('orders')->with('status', 'done');
    }
}
