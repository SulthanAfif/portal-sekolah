<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSchoolWifi
{
    public function handle(Request $request, Closure $next): Response
    {
        // Development: izinkan semua IP
        if (app()->environment('local')) {
            return $next($request);
        }

        $allowedRanges = config('school.wifi_allowed_ips', [
            '192.168.1.0/24',
            '192.168.0.0/24',
            '10.0.0.0/8',
        ]);

        $clientIp = $request->ip();

        if (! $this->isAllowedIp($clientIp, $allowedRanges)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Akses ditolak. Fitur ini hanya dapat digunakan melalui WiFi Sekolah.',
                    'ip'      => $clientIp,
                ], 403);
            }

            abort(403, 'Akses ditolak. Portal / fitur ini hanya dapat diakses melalui WiFi Sekolah. IP Anda: '.$clientIp);
        }

        return $next($request);
    }

    private function isAllowedIp(string $ip, array $ranges): bool
    {
        foreach ($ranges as $range) {
            if ($this->ipInRange($ip, $range)) {
                return true;
            }
        }

        return false;
    }

    private function ipInRange(string $ip, string $range): bool
    {
        if (strpos($range, '/') === false) {
            return $ip === $range;
        }

        [$subnet, $bits] = explode('/', $range);
        $ipLong = ip2long($ip);
        $subnetLong = ip2long($subnet);

        if ($ipLong === false || $subnetLong === false) {
            return false;
        }

        $mask = -1 << (32 - (int) $bits);

        return ($ipLong & $mask) === ($subnetLong & $mask);
    }
}
