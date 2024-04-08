<?php

namespace App\Http\Library;

use Illuminate\Http\JsonResponse;

trait ApiHelpers
{
    protected function isAdmin($user): bool
    {
        if (!empty($user)) {
            return $user->role == 'admin';
        }

        return false;
    }

    protected function onSuccess($data, string $message = '', int $total_page = null, int $code = 200): JsonResponse
    {
        $responseField = [
            'status' => $code,
            'message' => $message,
        ];
        if (!empty($data)) {
            if (!empty($total_page)) {
                $responseField = [...$responseField, 'data' => $data, 'total_page' => $total_page];
            }
            $responseField = [...$responseField, 'data' => $data];
        }
        return response()->json($responseField, $code);
    }

    protected function onError(int $code, $message = ''): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
        ], $code);
    }

    protected function productValidationRules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'image_url' => 'required',
            'category_id' => 'required',
        ];
    }

    protected function categoryValidationRules(): array
    {
        return [
            'name' => 'required|string|max:20',
            'description' => 'required',
        ];
    }

    protected function userRegisterValidatedRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    protected function userSignValidatedRules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
