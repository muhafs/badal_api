<?php

namespace App\Http\Traits;

trait ResponseJson
{
    function successJson($message, $data, $code)
    {
        return response()->json(
            [
                'message' => $message,
                'data' => $data
            ],
            $code
        );
    }

    function errorJson($message, $code)
    {
        return response()->json(
            [
                'message' => $message,
            ],
            $code
        );
    }
}
