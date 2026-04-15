<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ApiKey;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BazaarApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->header('X-API-KEY') ?: $request->query('api_key');

        $apiKey = ApiKey::where('key', $key)->first();
        if (!$apiKey) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $apiKey->increment('requests');
        $apiKey->last_used_at = now();
        $apiKey->save();

        return $next($request);
    }
}
