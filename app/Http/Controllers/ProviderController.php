<?php

namespace App\Http\Controllers;

use App\Models\OrderWaiting;
use App\Models\Provider;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProviderController extends Controller
{
    private function parseAmountToCents(mixed $value): int
    {
        if ($value === null || $value === '') {
            return 0;
        }

        $normalized = str_replace(',', '.', (string) $value);

        return max(0, (int) round(((float) $normalized) * 100));
    }

    /**
     * Display provider view
     */
    public function index(): View
    {
        $providers = Provider::orderBy('name')->get();
        return view('provider.index', compact('providers'));
    }

    /**
     * Display the user's profile form.
     */
    public function create(Request $request): View
    {
        return view('provider.create');
    }

    /**
     * Display the user's profile form.
     */
    public function store(Request $request): RedirectResponse 
    {
        $provider = new Provider();
        $provider->name = $request->name;
        $provider->email = $request->email;
        $provider->phone = $request->phone;
        $provider->comment = $request->comment;
        $provider->email_content = $request->email_content;
        $provider->shipping_cost = $this->parseAmountToCents($request->shipping_cost);
        $provider->is_stock = $request->has('is_stock') ? true : false;
        $provider->save();

        return Redirect::route('providers')->with('success', 'Fournisseur crée');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Provider $provider): View
    {
        if (! $provider->uuid) {
            $provider->uuid = (string) Str::uuid();
            $provider->save();
        }

        return view('provider.edit', [
            'provider' => $provider,
            'pricesUrl' => $provider->generatePricesUrl(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, Provider $provider): RedirectResponse
    {
        $provider->name = $request->name;
        $provider->email = $request->email;
        $provider->phone = $request->phone;
        $provider->comment = $request->comment;
        $provider->email_content = $request->email_content;
        $provider->shipping_cost = $this->parseAmountToCents($request->shipping_cost);
        $provider->is_stock = $request->has('is_stock') ? true : false;
        $provider->update();

        return Redirect::route('providers')->with('success', 'Fournisseur mis à jour');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Provider $provider)
    {
        foreach($provider->orderWaitings as $orderWaiting)
        {
            $orderWaiting->delete();
        }

        foreach($provider->products as $product)
        {
            $product->delete();
        }

        $provider->delete();
    }

    /**
     * Return products view.
     */
    public function products(Request $request)
    {
        $products = Product::where('products.provider_id', $request->provider_id)
            ->leftJoin('orders_waiting', 'orders_waiting.product_id', '=', 'products.id')
            ->leftJoin('unities', 'unities.id', '=', 'products.unity_id')
            ->orderBy('products.name')
            ->select([
                'products.id',
                'products.name',
                'unities.name as unity_name',
                'orders_waiting.quantity as quantity',
            ])->get();

        return view('provider.products', compact('products'));
    }

    /**
     * Update product quantity.
     */
    public function updateProductQuantity(Product $product, Request $request)
    {
        $orderWaiting = OrderWaiting::firstOrCreate([
            'product_id' => $product->id,
            'provider_id' => $product->provider_id,
            'unity_id' => $product->unity_id
        ]);

        $orderWaiting->quantity = $request->quantity;
        $orderWaiting->save();

        if ($orderWaiting->quantity == 0) {
            $orderWaiting->delete();
        }
    }
}
