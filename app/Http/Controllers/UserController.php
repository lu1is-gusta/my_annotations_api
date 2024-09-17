<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class UserController extends Controller
{
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
}
