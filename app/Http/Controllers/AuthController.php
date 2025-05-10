<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = JWTAuth::attempt($credentials)) {
            return $this -> ResponseSuccess([
                'success' => true,
                'token' => $token
            ], 200);
        }

        return $this -> ResponseError(['error' => 'Invalid credentials'], 401);
    }
}

