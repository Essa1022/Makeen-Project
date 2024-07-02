<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ResponseService
{
    public function success_response($data = "", string $message = "عملیات موفقیت آمیز"): JsonResponse
    {
        return response()->json([
            "success" => 'success',
            "message" => $message,
            "data" => $data
        ]);
    }

    public function error_response(string $message = "عملیات ناموفق"): JsonResponse
    {
        return response()->json([
            "success" => 'error',
            "message" => $message,
            "data" => ''
        ]);
    }

    public function unauthorized_response(): JsonResponse
    {
        return response()->json([
            "success" => 'error',
            "message" => 'شما مجاز به دسترسی به این منبع نیستید',
            "data" => ''
        ]);
    }

    public function delete_response(): JsonResponse
    {
        return response()->json([
            "success" => 'success',
            "message" => 'حذف شد',
        ]);
    }

    public function notFound_response(): JsonResponse
    {
        return response()->json([
            "success" => 'error',
            "message" => 'پیدا نشد',
        ]);
    }
}
