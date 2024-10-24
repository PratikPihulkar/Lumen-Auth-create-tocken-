<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    { 
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User created successfully'], 201);
    }


 public function login(Request $request)
{
    $this->validate($request, [
        'email' => 'required|string|email',
        'password' => 'required|string|min:6',
    ]);

    $credentials = $request->only(['email', 'password']);

    try {
        // if (!$token = JWTAuth::attempt($credentials)) {
        if (!$token = auth()->attempt($credentials)) {
            // Invalid credentials
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    } catch (JWTException $e) {
        // If there's an error while trying to create the token
        return response()->json(['error' => 'Could not create token'], 500);
    }

    // If successful, return the token details
    return $this->respondWithToken($token);
}

    // Refresh JWT token
    public function refreshToken()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    // Logout user
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

    // Helper method to return token details
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60, // Convert minutes to seconds
            // 'refresh_token' => auth()->refresh()
        ]);
    }

    public function checkMe()
    {
        return response()->json(auth()->user());
    }

}
