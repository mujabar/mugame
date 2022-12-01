<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User Created',
            'data' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('authToken')->plainTextToken;

                return response()->json([
                    'success' => true,
                    'message' => 'User Login',
                    'data' => $user,
                    'token' => $token
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Password Wrong',
                    'data' => ''
                ], 409);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User Not Found',
                'data' => ''
            ], 409);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();


        return response()->json([
            'success' => true,
            'message' => 'User Logout',
            'data' => ''
        ], 200);
    }
}
