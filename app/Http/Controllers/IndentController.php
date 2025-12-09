<?php

namespace App\Http\Controllers;

use App\Mail\ProviderEmail;
use App\Models\OrderWaiting;
use App\Models\Provider;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderLine;
use App\Services\IndentMail;
use Illuminate\Http\Request;
use App\Services\TenantMailer;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class IndentController extends Controller
{
    /**
     * Index view
     */
    public function index()
    {
        $providers = Provider::orderBy('name')->get();
        return view('indent.index', compact('providers'));
    }

    /**
     * Products list
     */
    public function products(Provider $provider)
    {
        $orderCount = OrderWaiting::where('provider_id', $provider->id)->sum('quantity');
        $products = Product::leftJoin('orders_waiting', 'orders_waiting.product_id', '=', 'products.id')
            ->where('products.provider_id', $provider->id)
            ->orderBy('products.name')
            ->select(['products.*', 'orders_waiting.quantity', 'orders_waiting.price as total'])->get();

        return view('indent.products', compact('provider', 'products', 'orderCount'));
    }

    /**
     * Items
     */
    public function items(Request $request)
    {
        $products = Product::leftJoin('orders_waiting', 'orders_waiting.product_id', '=', 'products.id')
            ->where('products.provider_id', $request->provider_id)
            ->orderBy('products.name')
            ->select(['products.*', 'orders_waiting.quantity', 'orders_waiting.price as total'])->get();

        return view('indent.items', compact('products'));
    }

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

    /**
     * Send email
     */
    public function send(Provider $provider, Request $request)
    {
        DB::transaction(function () use ($provider, $request) {
            $serviceIndent = new IndentMail();
            $emailContent = $serviceIndent->createIndentMail($provider, $request->content, $request->footer);
            $orderWaiting = OrderWaiting::where('provider_id', $provider->id)->get();

            $order = new Order();
            $order->uuid = Str::uuid()->toString();
            $order->provider_id = $provider->id;
            $order->user_id = $request->user()->id;
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
                'content' => $emailContent
            ];

            try 
            {
                TenantMailer::send(
                    $provider->tenant,
                    $provider->email,
                    new ProviderEmail($data, $order)
                );

                $order->is_sent = true;
                $order->update();

            } catch(\Exception $e)
            {
                return Redirect::route('indents')->with('error', "Erreur dans l'envoi de l'email");
            }
        });

        return Redirect::route('indents')->with('success', 'E-mail envoyé avec succès !');
    }
}
