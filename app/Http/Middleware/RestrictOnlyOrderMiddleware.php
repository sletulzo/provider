<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RestrictOnlyOrderMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user?->isCustomer() && $user->is_only_order) {
            abort(403, 'Accès réservé aux administrateurs du compte.');
        }

        return $next($request);
    }
}
