<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSiteAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user || ! $user->canManageSite()) {
            abort(403, 'Hanya Admin yang dapat mengatur website.');
        }
        return $next($request);
    }
}
