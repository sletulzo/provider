<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLine;
use App\Models\OrderWaiting;
use App\Services\OrderResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(private OrderResponseService $orderResponse) {}

    public function index(Request $request)
    {
        return view('order.index');
    }

    public function edit(Order $order)
    {
        $this->authorizeOrderAccess($order);
        $order->load(['lines.product', 'lines.unity', 'provider', 'user']);
        $status = $order->getStatus();

        return view('order.edit', compact('order', 'status'));
    }

    public function products(Order $order)
    {
        return view('order.products', compact('order'));
    }

    /**
     * Legacy signed accept URL — redirects to the response interface.
     */
    public function accept(Request $request)
    {
        $order = Order::findByUuid($request->uuid);

        if (! $order) {
            abort(404);
        }

        return redirect()->to($order->generateUrl());
    }

    /**
     * Public response interface (signed URL from email).
     */
    public function responseForm(Request $request, string $uuid): View
    {
        $order = $this->findOrderOrFail($uuid);
        $order->load(['lines.product', 'lines.unity', 'provider', 'user', 'tenant']);

        if ($order->isResponded()) {
            return view('front.order-response-done', [
                'order' => $order,
                'status' => $order->getStatus(),
            ]);
        }

        return view('front.order-response', [
            'order' => $order,
            'submitUrl' => URL::signedRoute('front.commande.submit', ['uuid' => $order->uuid]),
        ]);
    }

    /**
     * Submit provider response (signed URL).
     */
    public function submitResponse(Request $request, string $uuid)
    {
        $order = $this->findOrderOrFail($uuid);

        if ($order->isResponded()) {
            return redirect()->to($order->generateUrl());
        }

        $request->validate([
            'refuse_all' => 'nullable|boolean',
            'provider_note' => 'nullable|string|max:1000',
            'lines' => 'required_unless:refuse_all,1|array',
            'lines.*' => 'in:accepted,missing',
        ]);

        if ($request->boolean('refuse_all')) {
            $this->orderResponse->applyResponse($order, [], true, $request->input('provider_note'));
        } else {
            $this->orderResponse->applyResponse(
                $order,
                $request->input('lines', []),
                false,
                $request->input('provider_note')
            );
        }

        $order->refresh();

        return view('front.order-response-done', [
            'order' => $order,
            'status' => $order->getStatus(),
        ]);
    }

    /**
     * Provider backoffice — same interface, authenticated.
     */
    public function providerResponseForm(Order $order): View
    {
        $order->load(['lines.product', 'lines.unity', 'provider', 'user', 'tenant']);

        if ($order->isResponded()) {
            return view('front.order-response-done', [
                'order' => $order,
                'status' => $order->getStatus(),
                'backUrl' => route('orders.edit', $order),
            ]);
        }

        return view('front.order-response', [
            'order' => $order,
            'submitUrl' => route('provider.orders.submit', $order),
            'backUrl' => route('orders.edit', $order),
            'authenticated' => true,
        ]);
    }

    public function providerSubmitResponse(Request $request, Order $order)
    {
        if ($order->isResponded()) {
            return Redirect::route('orders.edit', $order);
        }

        $request->validate([
            'refuse_all' => 'nullable|boolean',
            'provider_note' => 'nullable|string|max:1000',
            'lines' => 'required_unless:refuse_all,1|array',
            'lines.*' => 'in:accepted,missing',
        ]);

        if ($request->boolean('refuse_all')) {
            $this->orderResponse->applyResponse($order, [], true, $request->input('provider_note'));
        } else {
            $this->orderResponse->applyResponse(
                $order,
                $request->input('lines', []),
                false,
                $request->input('provider_note')
            );
        }

        return Redirect::route('orders.edit', $order)->with('success', 'Réponse enregistrée avec succès.');
    }

    /** @deprecated Use providerResponseForm */
    public function providerAccept(Order $order)
    {
        if ($order->isResponded()) {
            return Redirect::route('orders');
        }

        $lineStatuses = $order->lines->mapWithKeys(fn (OrderLine $line) => [
            $line->id => OrderLine::STATUS_ACCEPTED,
        ])->all();

        $this->orderResponse->applyResponse($order, $lineStatuses);

        return Redirect::route('orders')->with('status', 'done');
    }

    /** @deprecated Use providerResponseForm */
    public function providerRefuse(Order $order)
    {
        if ($order->isResponded()) {
            return Redirect::route('orders');
        }

        $this->orderResponse->applyResponse($order, [], true);

        return Redirect::route('orders')->with('status', 'done');
    }

    public function delete(Order $order)
    {
        $this->authorizeOrderAccess($order);

        foreach ($order->lines as $line) {
            $line->delete();
        }

        $order->delete();

        return Redirect::route('orders')->with('status', 'done');
    }

    private function authorizeOrderAccess(Order $order): void
    {
        $user = Auth::user();

        if ($user->managesOwnCart() && $order->user_id !== $user->id) {
            abort(403);
        }
    }

    private function findOrderOrFail(string $uuid): Order
    {
        $order = Order::findByUuid($uuid);

        if (! $order) {
            abort(404);
        }

        return $order;
    }
}
