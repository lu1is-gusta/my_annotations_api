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

    public function create(StoreUserRequest $request): JsonResponse
    {
        $users = User::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "User Created successfully!",
            'users' => $users
        ], 201);
    }

    public function update($id)
    {
        
    }

    public function delete($id)
    {
        
    }
}
