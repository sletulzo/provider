<?php

namespace App\Http\Controllers;

use App\Mail\ProviderEmail;
use App\Models\OrderWaiting;
use App\Models\Provider;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderLine;
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
     * Produits du fournisseur avec quantités panier (sans jointure SQL pour éviter les doublons).
     */
    private function getProviderCatalog(Provider $provider, $user): array
    {
        $this->dedupeCartItems($user, $provider->id);

        OrderWaiting::query()
            ->forUserCart($user)
            ->where('provider_id', $provider->id)
            ->where(function ($query) {
                $query->whereNull('quantity')->orWhere('quantity', '<=', 0);
            })
            ->delete();

        $cartItems = OrderWaiting::query()
            ->forUserCart($user)
            ->where('provider_id', $provider->id)
            ->where('quantity', '>', 0)
            ->with('product')
            ->get()
            ->unique('product_id');

        $cartByProduct = $cartItems->keyBy('product_id');
        $orderCount = $cartItems->sum('quantity');
        $cartTotal = $cartItems->sum(fn (OrderWaiting $item) => $item->getPrice());

        $products = Product::query()
            ->where('provider_id', $provider->id)
            ->with('unity')
            ->orderBy('name')
            ->get()
            ->map(function (Product $product) use ($cartByProduct) {
                $product->quantity = (int) ($cartByProduct->get($product->id)?->quantity ?? 0);

                return $product;
            });

        return compact('products', 'orderCount', 'cartTotal');
    }

    /**
     * Supprime les lignes panier en double (même produit).
     */
    private function dedupeCartItems($user, int $providerId): void
    {
        $groups = OrderWaiting::query()
            ->forUserCart($user)
            ->where('provider_id', $providerId)
            ->orderByDesc('updated_at')
            ->get()
            ->groupBy('product_id');

        foreach ($groups as $group) {
            if ($group->count() <= 1) {
                continue;
            }

            $group->slice(1)->each->delete();
        }
    }

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
        $catalog = $this->getProviderCatalog($provider, Auth::user());

        return view('indent.products', array_merge(
            ['provider' => $provider],
            $catalog
        ));
    }

    /**
     * Items
     */
    public function items(Request $request)
    {
        $provider = Provider::findOrFail($request->provider_id);
        $catalog = $this->getProviderCatalog($provider, Auth::user());

        return view('indent.items', array_merge(
            ['provider' => $provider],
            $catalog
        ));
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
            ->where('quantity', '>', 0)
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
            ->where('quantity', '>', 0)
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
            ->where('quantity', '>', 0)
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
                ->where('quantity', '>', 0)
                ->get();

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
                'content' => $request->content,
                'footer'  => $request->footer,
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
