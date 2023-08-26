<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'email incorrect'
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'password incorrect'
            ]);
        }

        $authToken = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'auth_token' => $authToken,
            'user' => UserResource::make($user),
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required',
            'name' => 'required',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'role' =>  'user',
        ]);

        $authToken = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'auth_token' => $authToken,
            'user' => UserResource::make($user),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout successfully'
        ]);
    }
}
