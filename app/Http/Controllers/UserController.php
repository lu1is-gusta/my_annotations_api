<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\StoreUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Http\Requests\user\LoginUserRequest;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Services\AuthService;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(StoreUserRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return ApiResponse::responseJsonSuccess('User created', $user, 201);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();
        $data = (new AuthService($user, $request))->responseCredentialsUserLogin();

        return ApiResponse::responseJsonSuccess('Generated token', $data->toArray());
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return ApiResponse::responseJsonSuccess('logged out');
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $this->authorize('view', $user);

        return ApiResponse::responseJsonSuccess(null, $user);
    }

    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $user->update($request->validated());

        return ApiResponse::responseJsonSuccess('User updated successfully!', $user);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);

        $user->delete();

        return ApiResponse::responseJsonSuccess('User successfully deleted!');
    }
}
