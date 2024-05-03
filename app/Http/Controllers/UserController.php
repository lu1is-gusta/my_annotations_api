<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(): Response //ver melhor sobre o type de funções
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

    public function store(StoreUserRequest $request): array
    {
        
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
