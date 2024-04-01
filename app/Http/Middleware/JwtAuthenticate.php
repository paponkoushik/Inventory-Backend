<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $exception) {
            if ($exception instanceof TokenExpiredException) {
                $newToken = JWTAuth::parseToken()->refresh();
                return response()->json(['success'=> false, 'token' => $newToken, 'status' => 'Token Expired'], 200);
            } else if ($exception instanceof TokenInvalidException) {
                return response()->json(['success'=> false, 'status' => 'Token Invalid'], 401);
            } else {
                return response()->json(['success'=> false, 'status' => 'Token Not Found'], 401);
            }
        }
        return $next($request);
    }
}
