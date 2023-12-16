<?php

namespace App\Http\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait HasJsonResponse
{
    function jsonResponse($message, $data = [], $code = 200)
    {
        return response()->json(
            [
                'success' => true,
                'message' => $message,
                'data' => $data
            ],
            $code
        );
    }

    function throwResponse($message, $code = 400)
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'success' => false,
                    'message' => $message
                ],
                $code
            )
        );
    }
}
