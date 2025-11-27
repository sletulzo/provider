<?php

namespace App\Http\Controllers;

use App\Models\OrderWaiting;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Unity;
use Illuminate\Http\Request;
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
        $providerOrders = OrderWaiting::orderBy('created_at', 'desc')->get()->groupBy('provider_id');
        $orderFormatted = OrderWaiting::getFormattedEmail();
        
        return view('dashboard', compact('products', 'unities', 'providers', 'providerOrders', 'orderFormatted'));
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

    public function newIndex()
    {
        $providers = Provider::orderBy('name')->get();
        return view('test.index', compact('providers'));
    }

    public function productList(Request $request)
    {
        $products = Product::leftJoin('orders_waiting', 'orders_waiting.product_id', '=', 'products.id')
            ->where('products.provider_id', $request->provider_id)
            ->select([
                'products.id',
                'products.name',
                'products.unity_id',
                'orders_waiting.quantity'
            ])->get();

        return view('test.items', compact('products'));
    }

    public function productQuantity(Product $product, Request $request)
    {
        $type = $request->type;

        $orderWaiting = OrderWaiting::firstOrCreate([
            'product_id' => $product->id,
            'provider_id' => $product->provider_id
        ]);

        $orderWaiting->quantity = ($type == 'add') ? $orderWaiting->quantity + 1 : $orderWaiting->quantity - 1;
        $orderWaiting->update();

        if ($orderWaiting->quantity <= 0)
            $orderWaiting->delete();
        

        $products = Product::leftJoin('orders_waiting', 'orders_waiting.product_id', '=', 'products.id')
            ->where('products.provider_id', $product->provider_id)
            ->select([
                'products.id',
                'products.name',
                'products.unity_id',
                'orders_waiting.quantity'
            ])->get();

        return view('test.items', compact('products'));
    }
}
