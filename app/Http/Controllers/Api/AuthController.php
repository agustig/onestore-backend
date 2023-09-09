<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiHelpers;

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->userSignValidatedRules()
        );

        if ($validator->passes()) {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return $this->onError(
                    422,
                    ['email' => ['email incorrect.']]
                );
            }

            if (!Hash::check($request->password, $user->password)) {
                return $this->onError(
                    422,
                    ['password' => ['password incorrect']]
                );
            }
            $authToken = $user->createToken('auth-token')->plainTextToken;
            $userData = User::find($user->id, ['id', 'name']);

            $credentials = [
                'auth_token' => $authToken,
                'user' => UserResource::make($userData),
            ];

            return $this->onSuccess($credentials, 'Login successfully',);
        }
        return $this->onError(400, $validator->errors());
    }

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->userRegisterValidatedRules()
        );

        if ($validator->passes()) {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'name' => $request->name,
                'role' =>  'user',
            ]);

            $authToken = $user->createToken('auth-token')->plainTextToken;
            $userData = User::find($user->id, ['id', 'name']);

            $credentials = [
                'auth_token' => $authToken,
                'user' => UserResource::make($userData),
            ];

            return $this->onSuccess($credentials, 'Register successfully');
        }
        return $this->onError(400, $validator->errors());
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->onSuccess(null, 'Logout successfully');
    }
}
