<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display provider view
     */
    public function index(Request $request)
    {
        // $user = $request->user();

        // $query = Order::query()
        //     ->with(['provider', 'user', 'lines'])
        //     ->withCount('lines')
        //     ->orderByDesc('created_at');

        // if ($user->isCustomer() && $user->is_only_order) {
        //     $query->where('user_id', $user->id);
        // }

        // // filtre mois / année
        // $month = $request->filled('month') ? $request->month : now()->month;
        // $year = $request->filled('year') ? $request->year : now()->year;

        // $query->whereMonth('created_at', $month);
        // $query->whereYear('created_at', $year);
        // $orders = $query->get();

        // return view('order.index', [
        //     'orders' => $orders,
        //     'month' => $month,
        //     'year' => $year,
        // ]);

        return view('order.index');
    }

    /**
     * Edit order
     */
    public function edit(Order $order)
    {
        $status = $order->getStatus();
        return view('order.edit', compact('order', 'status'));
    }

    /**
     * Display products
     */
    public function products(Order $order)
    {
        return view('order.products', compact('order'));
    }

    /**
     * Accept order
     */
    public function accept(Request $request)
    {
        $order = Order::where('uuid', $request->uuid)->firstOrFail();
        $order->is_accepted = true;
        $order->update();

        return view('front.accept', ['order' => $order]);
    }

    /**
     * Accept order from provider
     */
    public function providerAccept(Order $order)
    {
        $order->is_refused = false;
        $order->is_accepted = true;
        $order->update();

        return Redirect::route('orders')->with('status', 'done');
    }

    /**
     * Refuse order from provider
     */
    public function providerRefuse(Order $order)
    {
        $order->is_refused = true;
        $order->is_accepted = false;
        $order->update();

        // Update stock
        $provider = $order->provider;

        if ($provider->is_stock)
        {
            foreach($order->lines as $line)
            {
                $product = $line->product;

                if ($product)
                    $product->addToStock($line->quantity);
            }
        }

        return Redirect::route('orders')->with('status', 'done');
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
