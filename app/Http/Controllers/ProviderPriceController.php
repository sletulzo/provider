<?php

namespace App\Http\Controllers;

use App\Services\ProviderPricesService;
use App\Models\Provider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProviderPriceController extends Controller
{
    public function __construct(private ProviderPricesService $pricesService) {}

    public function show(string $uuid): View
    {
        $provider = $this->findProviderOrFail($uuid);
        $provider->load('tenant');
        $products = $this->pricesService->getCatalogProducts($provider);

        return view('front.provider-prices', [
            'provider' => $provider,
            'products' => $products,
            'submitUrl' => $provider->generatePricesSubmitUrl(),
        ]);
    }

    public function submit(Request $request, string $uuid): View
    {
        $provider = $this->findProviderOrFail($uuid);
        $changes = $this->pricesService->updatePrices($provider, $request->input('prices', []));

        return view('front.provider-prices-done', [
            'provider' => $provider,
            'changesCount' => count($changes),
        ]);
    }

    protected function findProviderOrFail(string $uuid): Provider
    {
        $provider = Provider::findByUuid($uuid);

        if (! $provider) {
            abort(404);
        }

        return $provider;
    }
}
