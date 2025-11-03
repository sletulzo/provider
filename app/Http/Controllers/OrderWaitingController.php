<?php

namespace App\Http\Controllers;

use App\Models\OrderWaiting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderWaitingController extends Controller
{
    /**
     * Display provider view
     */
    public function save(Request $request): RedirectResponse
    {
        $orderWaiting = OrderWaiting::firstOrCreate([
            'provider_id' => $request->provider_id,
            'product_id' => $request->product_id,
            'unity_id' => $request->unity_id
        ]);

        $orderWaiting->user_id = $request->user()->id;
        $orderWaiting->quantity = $request->quantity;
        $orderWaiting->update();

        return Redirect::route('dashboard')->with('status', 'product-created');
    }

    /**
     * Update order waiting quantity
     */
    public function updateQuantity(OrderWaiting $orderWaiting, Request $request)
    {
        $orderWaiting->quantity = $request->value;
        $orderWaiting->update();
    }

    /**
     * Delete order waiting
     */
    public function delete(OrderWaiting $orderWaiting)
    {
        $orderWaiting->delete();

        return Redirect::route('dashboard')->with('status', 'product-deleted');
    }
}
