<?php

namespace App\Http\Controllers;

use App\Models\OrderWaiting;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Unity;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display provider view
     */
    public function index(): View
    {
        $providers = Provider::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $unities = Unity::orderBy('name')->get();
        $orderWaitings = OrderWaiting::orderBy('created_at', 'desc')->get();
        $orderFormatted = OrderWaiting::getFormattedEmail();
        
        return view('dashboard', compact('products', 'unities', 'providers', 'orderWaitings', 'orderFormatted'));
    }
}
