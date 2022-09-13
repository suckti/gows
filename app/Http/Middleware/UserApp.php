<?php

namespace App\Http\Middleware;

use Closure;

class UserApp
{
    protected $except = [
        'api/auth/register',
        'api/auth/login'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if (!empty($user) && $user->status == 'pending') {
            return response()->json([
                'message' => 'Please verify your account.',
            ], 500);
        }
        return $next($request);
    }
}
