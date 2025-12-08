<?php

namespace App\Http\Controllers;

use App\Models\OrderWaiting;
use App\Models\Provider;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IndentController extends Controller
{
    /**
     * Update quantity
     */
    public function quantity(Product $product, Request $request)
    {
        $orderWaiting = OrderWaiting::firstOrCreate([
            'product_id' => $product->id,
            'provider_id' => $product->provider_id
        ]);

        $quantity = ($request->type == 'add') ? $orderWaiting->quantity + 1 : $orderWaiting->quantity - 1;
        $orderWaiting->quantity = $quantity;
        $orderWaiting->price = $product->price * $orderWaiting->quantity;
        $orderWaiting->unity_id = $product->unity_id;
        $orderWaiting->update();

        if ($quantity <= 0)
        {
            $quantity = 0;
            $orderWaiting->delete();
        }

        return response()->json([
            'value' => $quantity,
            'count' => floatval(OrderWaiting::where('provider_id', $product->provider_id)->sum('quantity'))
        ]);
    }

    /**
     * Indent shop cart
     */
    public function shopCart(Provider $provider): View
    {
        $indents = OrderWaiting::where('provider_id', $provider->id)->get();
        return view('indent.shop-cart', compact('provider', 'indents'));
    }

    /**
     * Preview email
     */
    public function preview(Provider $provider): View
    {
        $indents = OrderWaiting::where('provider_id', $provider->id)->get();
        return view('indent.preview', compact('provider', 'indents'));
    }
}
