<?php

namespace App\Traits;

trait ResponseTraits{

    function Success($message = 'Success', $status = 'success', $data, $code = 200)
    {
        // dd($message, $status, $data, $code);
        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ], $code);
    }
    
    function Error($message = 'Success', $status = 'success', $data, $code = 402)
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ], $code);
    }
}
