<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\UserInfo\UserInfoResource;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    protected $service;
    public function __construct(AuthService $authService)
    {
        $this->service = $authService;
    }
    public function login(Request $request): JsonResponse
    {
        return $this
            ->service
            ->login($request->only('email', 'password'));
    }
    public function signup(SignupRequest $request): JsonResponse
    {
        return $this
            ->service
            ->setAttrs($request->only('name', 'email', 'password'))
            ->signup();
    }
    public function refresh(): JsonResponse
    {
        return $this->service->refreshAuthUserToken();
    }
    public function logout(): JsonResponse
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function myself(): AnonymousResourceCollection
    {
        return UserInfoResource::collection(
            User::query()
                ->where('id', auth()->user()->id)
                ->get()
        );
    }
}
