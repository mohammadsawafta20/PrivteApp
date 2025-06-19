<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function successResponse($data = [], $message = 'تم بنجاح', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    protected function errorResponse($message = 'حدث خطأ ما', $errors = [], $code = 422)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $code);
    }
}
