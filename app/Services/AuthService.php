<?php

namespace App\Services;

use App\Models\User;

class AuthService {

    public function generateToken(User $user) : string
    {
        $token = $user->createToken($user->name.'-auth_token')->plainTextToken;

        return $token;
    }
}
