<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$token || !Str::startsWith($token, 'Bearer ')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $apiToken = Str::substr($token, 7); // 移除 'Bearer ' 前缀

        if (!User::where('api_token', $apiToken)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }

}
