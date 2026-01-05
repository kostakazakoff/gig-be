<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponses
{
    protected function success($data, $message = null, $code = 200): JsonResponse
    {
        $response = [
            'succeed' => true,
            'data' => $data,
        ];

        if ($message) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }

    protected function error($message = null, $code = 400): JsonResponse
    {
        return response()->json([
            'succeed' => false,
            'message' => $message,
        ], $code);
    }
}
