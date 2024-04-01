<?php

namespace App\Services\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function login(array $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request['email_or_username'], 'password' => $request['password']])) {
            $token = JWTAuth::fromUser(Auth::user());
            return response()->json(compact('token'));
        }

        if (Auth::attempt(['username' => $request['email_or_username'], 'password' => $request['password']])) {
            $token = JWTAuth::fromUser(Auth::user());
            return response()->json(compact('token'));
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    protected function respondWithToken($token): JsonResponse
    {
        response()->json(['success'=> true, 'token' => $token, 'status' => 'New'], 200);
    }
}
