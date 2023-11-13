<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpiredPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);

        // $user = $request->user();

        // if (!$user || $user->is_expired_password) {
        //     return response()->json([
        //         'message' => 'É necessário alterar a senha.'
        //     ], HTTP_CODE_UNAUTHORIZED);
        // }

        // return $next($request);
    }
}
