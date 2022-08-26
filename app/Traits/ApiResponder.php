<?php

namespace App\Traits;

trait ApiResponder
{
    public function success($message = '', $code = 200)
    {
        return response()->json(['message' => $message], $code);
    }

    public function data($message = '', $data = [])
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ]);
    }

    public function error($message = '', $data = [], $code = 400)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
