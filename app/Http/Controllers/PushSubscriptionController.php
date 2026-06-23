<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PushSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'endpoint' => 'required|string',
            'keys.auth' => 'required|string',
            'keys.p256dh' => 'required|string',
            'contentEncoding' => 'nullable|string',
        ]);

        /** @var User $user */
        $user = $request->user();

        $user->updatePushSubscription(
            $data['endpoint'],
            $data['keys']['p256dh'],
            $data['keys']['auth'],
            $data['contentEncoding'] ?? null
        );

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'endpoint' => 'required|string',
        ]);

        /** @var User $user */
        $user = $request->user();

        $user->deletePushSubscription($data['endpoint']);

        return response()->json(['success' => true]);
    }
}
