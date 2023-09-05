<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use ApiHelpers;

    public function show(Request $request)
    {
        return $this->onSuccess(
            UserResource::make($request->user()),
            'Profile retrieved',
        );
    }
}
