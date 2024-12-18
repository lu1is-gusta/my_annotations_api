<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\StoreUserRequest;
use App\Http\Requests\user\LoginUserRequest;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(LoginUserRequest $request){
        $loginUserData = $request->validate([]);

        $user = User::where('email',$loginUserData['email'])->first();

        if(!$user || !Hash::check($loginUserData['password'], $user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }

        $instanceAuthService = new AuthService;
        $token = $instanceAuthService->generateToken($user);

        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function logout(){
        dd(auth());
        // auth()->user()->tokens()->delete();

        return response()->json([
            "message"=>"logged out"
        ]);
    }

    public function index(): JsonResponse 
    {
        $users = User::all();
        
        return response()->json([
            'status' => true,
            'users' => $users
        ], 200);
    }

    public function show(int $id): JsonResponse 
    {
        $user = User::findOrFail($id);
        
        return response()->json([
            'status' => true,
            'user' => $user
        ], 200);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        dd($request);
        $user = User::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => "User created successfully!",
            'user' => $user
        ], 201);
    }

    public function update(int $id, StoreUserRequest $request): JsonResponse
    {
        $user = User::findOrFail($id);

        $user->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => "User updated successfully!",
            'user' => $user
        ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => "User successfully deleted!",
            'user' => $user
        ], 200);
        
    }

    public function register(StoreUserRequest $request)
    {
        dd($request->validated(), 'aqui');
    }
}
