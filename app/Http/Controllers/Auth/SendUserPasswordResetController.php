<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class SendUserPasswordResetController extends Controller
{
    public function __invoke(User $user): RedirectResponse
    {
        if (request()->routeIs('provider.users.sendReset')) {
            abort_unless(
                Auth::user()->isProvider()
                && $user->tenant_id === Auth::user()->tenant_id
                && $user->isCustomer()
                && $user->is_only_order,
                403
            );
        }

        $status = Password::sendResetLink([
            'email' => $user->email,
        ]);

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
