<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetReferrerPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!$response->headers->has('Referrer-Policy')) {
            $policy = (string) config('app.referrer_policy', 'strict-origin-when-cross-origin');

            if ($policy !== '') {
                $response->headers->set('Referrer-Policy', $policy);
            }
        }

        return $response;
    }
}
