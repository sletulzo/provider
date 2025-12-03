<?php

namespace App\Http\Controllers;

use App\Models\OrderWaiting;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IndentController extends Controller
{
    /**
     * Indent shop cart
     */
    public function shopCart(Provider $provider): View
    {
        $indents = OrderWaiting::where('provider_id', $provider->id)->get();
        return view('test.shop-cart', compact('provider', 'indents'));
    }
}
