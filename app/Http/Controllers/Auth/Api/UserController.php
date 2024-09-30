<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status_code' => 422,
                'message' => 'Unauthorized'
            ]);
        }
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status_code' => 422,
                'message' => 'Password did not match'
            ]);
        }

        $token_result = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'status_code' => 200,
            'access_token' => $token_result,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'status_code' => 200,
            'message' => 'Logged out'
        ]);
    }
}
