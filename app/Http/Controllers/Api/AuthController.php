<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Api\BaseController as BaseController;
class AuthController extends BaseController
{
    //
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth()->user();
        $token = $this->respondWithToken($token);

        // return $this->sendResponse($token, 'User logged in successfully.');
         return $this->sendResponse(['user' => $user, 'token' => $token], 'User logged in successfully');
}

public function profile(Request $request)
{
     
    return $this->sendResponse(auth()->user(), 'User profile retrieved successfully.');
}

public function logout(Request $request)
{
    auth('api')->logout();
    return $this->sendResponse([], 'User logged out successfully.');
}
}