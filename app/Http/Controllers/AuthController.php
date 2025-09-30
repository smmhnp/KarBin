<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $emailHash = hash('sha256', $credentials['email']);
        $user = User::where('email_hash', $emailHash)->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return $this->ResponseError(['error' => 'Invalid credentials'], 401);
        }

        $token = JWTAuth::fromUser($user);

        return $this->ResponseSuccess([
            'success' => true,
            'token' => $token
        ], 200);
    }
}

