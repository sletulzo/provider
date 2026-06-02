<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderWaiting;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Unity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display provider view
     */
    public function index(): View
    {
        $user = Auth::user();
        $view = $user->getNavigationSlug();
        $products = Product::take(2)->get();
        $providers = Provider::orderBy('name')->get();

        if ($user->isCustomer()) 
        {
            $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(4)->get();
            $products = Product::popular()->get();
        } 
        else
        {
            $orders = Order::orderBy('created_at', 'desc')->take(4)->get();
            $products = Product::popular()->get();
        }

        return view('dashboard.' . $view, compact('user', 'orders', 'products', 'providers'));
    }

    /**
     * Section order waiting
     */
    public function sectionOrderWaiting()
    {
        $providerOrders = OrderWaiting::orderBy('created_at', 'desc')->get()->groupBy('provider_id');
        return view('section.order-waiting', compact('providerOrders'));
    }

    /**
     * Section order email
     */
    public function sectionOrderEmail()
    {
        $orderFormatted = OrderWaiting::getFormattedEmail();
        return view('section.order-email', compact('orderFormatted'));
    }
}
