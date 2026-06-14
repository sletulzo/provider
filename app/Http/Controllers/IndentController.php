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
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        $cartItems = OrderWaiting::query()
            ->forUserCart($user)
            ->where('provider_id', $provider->id)
            ->with('product')
            ->get();
        $orderCount = $cartItems->sum('quantity');
        $cartTotal = $cartItems->sum(fn (OrderWaiting $item) => $item->getPrice());

        $products = Product::query()
            ->where('products.provider_id', $provider->id)
            ->leftJoin('orders_waiting', function ($join) use ($user) {
                $join->on('orders_waiting.product_id', '=', 'products.id');
                if ($user->managesOwnCart()) {
                    $join->where('orders_waiting.user_id', '=', $user->id);
                } else {
                    $join->whereNull('orders_waiting.user_id');
                }
            })
            ->orderBy('products.name')
            ->select(['products.*', 'orders_waiting.quantity', 'orders_waiting.price as total'])
            ->get();

        return view('indent.products', compact('provider', 'products', 'orderCount', 'cartTotal'));
    }

    /**
     * Items
     */
    public function items(Request $request)
    {
        $provider = Provider::findOrFail($request->provider_id);
        $user = Auth::user();
        $cartItems = OrderWaiting::query()
            ->forUserCart($user)
            ->where('provider_id', $provider->id)
            ->with('product')
            ->get();
        $orderCount = $cartItems->sum('quantity');
        $cartTotal = $cartItems->sum(fn (OrderWaiting $item) => $item->getPrice());

        $products = Product::query()
            ->where('products.provider_id', $provider->id)
            ->leftJoin('orders_waiting', function ($join) use ($user) {
                $join->on('orders_waiting.product_id', '=', 'products.id');
                if ($user->managesOwnCart()) {
                    $join->where('orders_waiting.user_id', '=', $user->id);
                } else {
                    $join->whereNull('orders_waiting.user_id');
                }
            })
            ->orderBy('products.name')
            ->select(['products.*', 'orders_waiting.quantity', 'orders_waiting.price as total'])
            ->get();

        return view('indent.items', compact('products', 'provider', 'orderCount', 'cartTotal'));
    }

    /**
     * Update quantity
     */
    public function quantity(Product $product, Request $request)
    {
        $orderWaiting = OrderWaiting::findOrCreateForCart($product->id, $product->provider_id);

        $step = $product->quantity_step ?? 1;
        $quantity = ($request->type == 'add') ? $orderWaiting->quantity + $step : $orderWaiting->quantity - $step;
        
        // Check stock before update
        // ---------------------------------------------------------
        $provider = $product->provider;

        if ($provider->is_stock)
        {
            $stock = $product->getStock();

            if ($quantity > $stock)
                $quantity = $stock;
        }

        $orderWaiting->quantity = $quantity;
        $orderWaiting->price = $product->price * $orderWaiting->quantity;
        $orderWaiting->unity_id = $product->unity_id;
        $orderWaiting->update();

        if ($quantity <= 0)
        {
            $quantity = 0;
            $orderWaiting->delete();
        }

        $cartItems = OrderWaiting::query()
            ->forUserCart(Auth::user())
            ->where('provider_id', $product->provider_id)
            ->get();
        $cartCount = floatval($cartItems->sum('quantity'));
        $cartTotal = $cartItems->sum(fn (OrderWaiting $item) => $item->getPrice());

        return response()->json([
            'value' => $quantity,
            'count' => $cartCount,
            'total' => price($cartTotal, 2) . ' €',
        ]);
    }

    /**
     * Indent shop cart
     */
    public function shopCart(Provider $provider): View
    {
        $indents = OrderWaiting::query()
            ->forUserCart(Auth::user())
            ->where('provider_id', $provider->id)
            ->get();

        $orderCount = floatval($indents->sum('quantity'));
        $cartTotal = $indents->sum(fn (OrderWaiting $item) => $item->getPrice());

        return view('indent.shop-cart', compact('provider', 'indents', 'orderCount', 'cartTotal'));
    }

    /**
     * Preview email
     */
    public function preview(Provider $provider): View
    {
        $indents = OrderWaiting::query()
            ->forUserCart(Auth::user())
            ->where('provider_id', $provider->id)
            ->get();

        $orderCount = floatval($indents->sum('quantity'));
        $cartTotal = $indents->sum(fn (OrderWaiting $item) => $item->getPrice());

        return view('indent.preview', compact('provider', 'indents', 'orderCount', 'cartTotal'));
    }

    /**
     * Send email
     */
    public function send(Provider $provider, Request $request)
    {
        DB::transaction(function () use ($provider, $request) {
            $orderWaiting = OrderWaiting::query()
                ->forUserCart($request->user())
                ->where('provider_id', $provider->id)
                ->get();

            $serviceIndent = new IndentMail();
            $emailContent = $serviceIndent->createIndentMail($orderWaiting, $request->content, $request->footer);

            $order = new Order();
            $order->uuid = Str::uuid()->toString();
            $order->provider_id = $provider->id;
            $order->user_id = $request->user()->id;
            $order->save();

            foreach($orderWaiting as $item)
            {
                // Update prodct stock
                if ($provider->is_stock)
                {
                    $product = Product::find($item->product_id);
                    $product->removeToStock($item->quantity);
                }

                $orderLine = OrderLine::firstOrCreate([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'unity_id' => $item->unity_id,
                ]);

                $orderLine->quantity = $item->quantity;
                $orderLine->status = OrderLine::STATUS_PENDING;
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
