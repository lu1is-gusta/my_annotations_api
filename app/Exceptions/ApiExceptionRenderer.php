<?php

namespace App\Exceptions;

use App\Services\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiExceptionRenderer
{
    public function __invoke(Throwable $e, Request $request): ?JsonResponse
    {
        if (! ($request->is('api/*') || $request->expectsJson())) {
            return null;
        }

        if ($e instanceof ValidationException) {
            return ApiResponse::responseJsonError($e->getMessage(), 422, ['errors' => $e->errors()]);
        }

        if ($e instanceof AuthenticationException) {
            return ApiResponse::responseJsonError('Unauthenticated.', 401);
        }

        if ($e instanceof AuthorizationException) {
            return ApiResponse::responseJsonError($e->getMessage() ?: 'This action is unauthorized.', 403);
        }

        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return ApiResponse::responseJsonError('Resource not found.', 404);
        }

        $status = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;

        $extra = [];

        if (config('app.debug')) {
            $extra = [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace(),
            ];
        }

        return ApiResponse::responseJsonError($e->getMessage() ?: 'Server Error.', $status, $extra);
    }
}
