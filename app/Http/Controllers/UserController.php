<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\StoreUserRequest;
use App\Http\Requests\user\LoginUserRequest;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Services\AuthService;
use App\Services\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $responseMessage = 'User created';

            return Response::responseJsonSucess($responseMessage, $user);

        } catch(\Exception $e) {
            return Response::responseJsonError($e, 500);
        }
    }
    
    public function login(LoginUserRequest $request): JsonResponse
    {
        try {
            $user = User::where('email',$request->email)->first();
            $instanceAuthService = new AuthService($user, $request);
            $token = $instanceAuthService->generateToken();
            $responseMessage = 'Generated token';

            return Response::responseJsonSucess($responseMessage, $token);

        } catch(\Exception $e) {
            return Response::responseJsonError($e, 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->tokens()->delete();
            $responseMessage = "logged out";

            return Response::responseJsonSucess($responseMessage);

        } catch(\Exception $e) {
            return Response::responseJsonError($e, 500);
        }
    }

    public function index(): JsonResponse 
    {
        try {
            $users = User::all();
        
            return Response::responseJsonSucess(null, $users);

        } catch(\Exception $e) {
            return Response::responseJsonError($e, 500);
        }
    }

    public function show(int $id): JsonResponse 
    {
        try {
            $user = User::findOrFail($id);
        
            return Response::responseJsonSucess(null, $user);

        } catch(\Exception $e) {
            return Response::responseJsonError($e, 500);
        }
    }

    public function update(int $id, StoreUserRequest $request): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->validated());
            $responseMessage = "User updated successfully!";

            return Response::responseJsonSucess($responseMessage, $user);

        } catch(\Exception $e) {
            return Response::responseJsonError($e, 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            $responseMessage = "User successfully deleted!";

            return Response::responseJsonSucess($responseMessage, $user);
            
        } catch(\Exception $e) {
            return Response::responseJsonError($e, 500);
        }
    }
}
