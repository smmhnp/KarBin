<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;



class UserApiController extends ApiController
{
    //................................................all.users..........................

    public function users()
    {
        return $this->ResponseSuccess(User::all(), 200);
    }


    //................................................register...........................

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'nickname' => 'required|string|max:255|unique:users,nickname',
                'role' => 'required|string|max:255',
                'unit' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|confirmed|min:6',
            ]);

            $user = User::create([
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
                'nickname' => $validated['nickname'],
                'role' => $validated['role'],
                'unit' => $validated['unit'],
                'email' => $validated['email'],
                'email_hash' => hash('SHA256', $validated['email']),
                'password' => Hash::make($validated['password']),
            ]);

            return response()->json([
                'success' => true,
                'user' => $user,
                'message' => 'User registered successfully'
            ], 201); // 201 Created

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    //................................................logout.............................

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return $this->ResponseError([
                'message' => 'No authenticated user'
            ], 401);
        }

        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return $this->ResponseSuccess([
                'message' => 'Logged out successfully'
            ], 200);
            
        } catch (Exception $e) {
            return $this->ResponseError([
                'message' => 'Logout failed', 'error' => $e->getMessage()
            ], 500);
        }
    }
}


