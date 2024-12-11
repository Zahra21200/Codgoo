<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($data = [], $message = null, $code = 200)
    {

        if(!$message){
            $message = __('messages.success');
        }
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error($message = null, $errors = [], $code = 400)
    {
        if(!$message){
            $message = __('messages.error');
        }

        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
