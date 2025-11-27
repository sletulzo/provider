<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Provider;
use App\Models\Unity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display provider view
     */
    public function index(): View
    {
        $providers = Provider::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('product.index', compact('products', 'providers'));
    }

    /**
     * Display the user's profile form.
     */
    public function create(Request $request): View
    {
        $providers = Provider::orderBy('name')->get();
        $unities = Unity::orderBy('name')->get();

        return view('product.create', compact('providers', 'unities'));
    }

    /**
     * Display the user's profile form.
     */
    public function store(Request $request): RedirectResponse 
    {
        $product = new Product();
        $product->name = $request->name;
        $product->unity_id = $request->unity_id;
        $product->provider_id = $request->provider_id;
        $product->quantity_min = $request->quantity_min;
        $product->quantity_step = $request->quantity_step;
        $product->save();

        return Redirect::route('products')->with('status', 'product-created');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Product $product): View
    {
        $providers = Provider::orderBy('name')->get();
        $unities = Unity::orderBy('name')->get();

        return view('product.edit', [
            'product' => $product,
            'providers' => $providers,
            'unities' => $unities
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->name = $request->name;
        $product->unity_id = $request->unity_id;
        $product->provider_id = $request->provider_id;
        $product->quantity_min = $request->quantity_min;
        $product->quantity_step = $request->quantity_step;
        $product->update();

        return Redirect::route('products')->with('success', 'Modifications enregistrées avec succès !');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return Redirect::route('products')->with('status', 'product-deleted');
    }
}
