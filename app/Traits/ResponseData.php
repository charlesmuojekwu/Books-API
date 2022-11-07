<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ResponseData
{
    /**
     * return  response.
     *
     * @param int $status_code
     * @param string $status_message
     * @param string $message
     * @param array $data
     * @return Response
     */
    public function sendResponse($status_code,$status_message, $data = null,$message=null)
    {
        $response = [
            'status_code'=> $status_code,
            'status' => $status_message,

        ];

        if($message != null){
            $response['message'] = $message;
        }

        if($data != null){
            $response['data'] = $data;
        }

        return response()->json($response, $status_code);
    }



    public function sendDeleteResponse($status_code,$status_message,$message=null)
    {
        $response = [
            'status_code'=> $status_code,
            'status' => $status_message,

        ];

        if($message != null){
            $response['message'] = $message;
        }

        $response['data'] = [];


        return response()->json($response);
    }
}
