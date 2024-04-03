<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService extends BaseService
{
    public function login(array $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $token = JWTAuth::fromUser(Auth::user());
            return response()->json(compact('token'));
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json(['success'=> true, 'token' => $token, 'status' => 'New'], 200);
    }
    public function signup(): JsonResponse
    {
//        dd($this->getAttr('name'));
        $user = User::query()->create([
            'name' => $this->getAttr('name'),
            'email' => $this->getAttr('email'),
            'password' => bcrypt($this->getAttr('password'))
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => true,
            'message' => 'User Registered Successfully',
            'token' => $token
        ], 200);
    }

    public function refreshAuthUserToken(): JsonResponse
    {
        $newToken = JWTAuth::refresh();
        return $this->respondWithToken($newToken);
    }
}
