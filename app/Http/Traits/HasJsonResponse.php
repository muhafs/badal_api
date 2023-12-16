<?php

namespace App\Http\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait HasJsonResponse
{
    function jsonResponse($code, $message, $data = null)
    {
        return response()->json(
            [
                'message' => $message,
                'data' => $data
            ],
            $code
        );
    }

    function throwResponse($code, $message)
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'message' => $message
                ],
                $code
            )
        );
    }
}
