<?php 

namespace App\Services;

use App\DTO\ExceptionResponseDTO;
use Exception;
use Illuminate\Http\JsonResponse;

class Response 
{
    public static function responseJsonSucess(?string $message = null, $data = [], ?int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public static function responseJsonError(Exception $error, ?int $status = null): JsonResponse
    {
        $exceptionDTO = new ExceptionResponseDTO($error);

        if(env('APP_DEBUG')){

            return response()->json([
                'error' => true,
                'message' => $error->getMessage(),
                'code'=> $error->getCode(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
                'stack_trace' => $error->getTraceAsString()
            ], $status);
        }

        return response()->json(
            $exceptionDTO->basicInformationException()
        //     [
        //     'error' => true,
        //     'message' => $error->getMessage()
        // ]
        , $status);
    }
}