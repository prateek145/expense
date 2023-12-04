<?php

namespace App\Http\Controllers;



class ApiController extends Controller
{
    public function __construct(){
       // parent::__construct();
        // $this->middleware('auth:sanctum',[
        //     'except' => ['login','forgotPassword','verifyOTP','sendOTP','onBording', 'signup','TokenError', 'sanctum/csrf-cookie']
        // ]);
    }

    public function sendResponse($result, $message, $recordCount = null){
        $response = [
            'status' => true,
            'responseCode' => 200,
            'message' => $message,
            'result'    => $result,
            'timestamp' => date('d-m-Y H:s:i a'),
        ];

        // dd($response);
        return response()->json($response);
    }

    public function sendError($errorMessages = 'Something Went Worng.Please try Again !', $result = [], $code = 402)
    {
        // dd($result, $errorMessages);
        $response = [
            'status' => false,
            'responseCode' => $code,
            'shortMsg' => 'Failed',
            'message' => $errorMessages,
            'result' => $result,
            'timestamp' => date('d-m-Y H:s:i a')
        ];

        return response()->json($response);
    }

    public function sendResponse1($result, $message, $recordCount = null){
        $response = [
            'status' => true,
            'responseCode' => 200,
            'message' => $message,
            'timestamp' => date('d-m-Y H:s:i a'),
            'result'    => $result
        ];

        // dd($response);
        return $response;
    }

    public function sendError1( $result = [], $errorMessages = 'Something Went Worng.Please try Again !', $code = 402)
    {
        // dd($result, $errorMessages);
        $response = [
            'status' => false,
            'responseCode' => $code,
            'shortMsg' => 'Failed',
            'message' => $errorMessages,
            'timestamp' => date('d-m-Y H:s:i a'),
            'result' => $result
        ];

        return $response;
    }

}
