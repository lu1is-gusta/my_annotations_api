<?php 

namespace App\Services;

use Illuminate\Http\JsonResponse;

final class ApiResponse 
{
    public static function responseJsonSuccess(?string $message = null, $data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function responseJsonError(?string $message = null, int $status = 500, array $extra = []): JsonResponse
    {
        return response()->json(array_merge([
            'status' => false,
            'message' => $message,
        ], $extra), $status);
    }
}
