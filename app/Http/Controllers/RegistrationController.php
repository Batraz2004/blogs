<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function createUser(RegistrationRequest $request)
    {
        /** @var User $user */
        $user = User::query()->create($request->getData());
        $token = $user->createToken($request->userAgent());

        return response()->json([
            'data' => $token,
        ], 200);
    }
}
