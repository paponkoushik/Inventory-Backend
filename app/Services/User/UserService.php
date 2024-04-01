<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserService
{
    public function searchUsers($request): JsonResponse
    {
        $query = $request->input('query');

        $results = User::query()
            ->where(function ($q) use ($query) {
                $q->where('username', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%');
            })
            ->get();

        return response()->json($results);
    }
}
