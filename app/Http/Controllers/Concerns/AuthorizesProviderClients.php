<?php

namespace App\Http\Controllers\Concerns;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait AuthorizesProviderClients
{
    protected function ensureProviderClient(User $user): void
    {
        abort_unless(
            Auth::user()->isProvider()
            && $user->tenant_id === Auth::user()->tenant_id
            && $user->isCustomer()
            && $user->is_only_order,
            403
        );
    }
}
