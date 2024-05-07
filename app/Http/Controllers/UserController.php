<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        ]);
    }

    public function create(): array
    {
        
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $users = User::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "User Created successfully!",
            'users' => $users
        ], 200);
    }

    public function show($id): array
    {
       
    }

    public function edit(): array
    {
        
    }

    public function update($id): array
    {
        
    }

    public function destroy($id): array
    {
        
    }
}
