<?php

namespace App\Services;

use App\DTO\ResponseLoginDataUserDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService 
{
    protected Model $instanceUserModel;
    protected Request $request;

    public function __construct(Model $instanceUserModel, Request $request)
    {
        $this->instanceUserModel = $instanceUserModel;
        $this->request = $request;
    }

    public function generateToken(): string
    {
        $this->verifyCredentialsUser();
        $token = $this->instanceUserModel->createToken($this->instanceUserModel->name.'-auth_token')->plainTextToken;

        return $token;
    }

    public function verifyCredentialsUser(): void
    {
        if(!$this->instanceUserModel || !Hash::check($this->request->password, $this->instanceUserModel->password)){
            throw new \Exception('Invalid credentials', 401);
        }
    }

    public function responseCredentialsUserLogin(): ResponseLoginDataUserDTO
    {
        $token = $this->generateToken();
        $userData = [
            'id' => $this->instanceUserModel->id,
            'name' => $this->instanceUserModel->name,
            'email' => $this->instanceUserModel->email,
        ];

        $responseDto = new ResponseLoginDataUserDTO(
            $token,
            $userData
        );

        return $responseDto;
    }
}
