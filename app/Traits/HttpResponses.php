<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use League\Uri\Http;

trait HttpResponses
{
    protected function success($data, $message = null, $code = 200)
    {
        if (request()->expectsJson()) {
            $response = [
                'succeed' => true,
                'data' => $data,
            ];

            if ($message) {
                $response['message'] = $message;
            }

            return response()->json($response, $code);
        }

        // For HTML requests, return redirect with success message
        return back()->with('success', $message ?? 'Operation successful');
    }

    protected function error($message = null, $code = 400)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'succeed' => false,
                'message' => $message,
            ], $code);
        }

        // For HTML requests, return back with error message
        return back()->withErrors(['error' => $message ?? 'An error occurred']);
    }
}
