<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user || ! $user->canManageData()) {
            abort(403, 'Hanya Admin / TU yang dapat mengakses halaman ini.');
        }
        return $next($request);
    }
}
