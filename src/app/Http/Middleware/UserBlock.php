<?php

namespace App\Http\Middleware;

use App\Repositories\UserRepository;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class UserBlock
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (resolve(UserRepository::class)->isBlock())
            return response()->json([
                'message' => 'You are blocked'
            ], Response::HTTP_FORBIDDEN);
        else
            return $next($request);

    }
}
