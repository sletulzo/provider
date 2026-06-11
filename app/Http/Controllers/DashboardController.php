<?php

namespace App\Http\Controllers;

use App\Models\OrderWaiting;
use App\Services\CustomerDashboardService;
use App\Services\ProviderDashboardService;
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

        if ($user->isCustomer()) {
            $dashboard = new CustomerDashboardService($user);

            return view('dashboard.customer', [
                'user' => $user,
                'stats' => $dashboard->getStats(),
                'draftCarts' => $dashboard->getDraftCarts(),
                'products' => $dashboard->getPopularProducts(),
                'providers' => $dashboard->getPopularProviders(),
            ]);
        }

        $dashboard = new ProviderDashboardService($user);

        return view('dashboard.provider', [
            'user' => $user,
            'stats' => $dashboard->getStats(),
            'pendingOrders' => $dashboard->getPendingOrders(),
            'products' => $dashboard->getPopularProducts(),
        ]);
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
