<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function response($data, $type = "get") 
    {
        if (!empty($data['errors'])) {
            $statusCode = 400;

            $response = ['status' => 0, 'data' => [], 'errors' => $data['errors']];
        } else {
            $data = is_object($data) ? $data->toArray() : $data;
            
            if (count($data)) {
                $status = 1;

                $statusCode = 200;
            } else {
                $status = 0;

                $statusCode = 400;
            }

            $response = ['status' => $status, 'data' => $data, 'errors' => []];
        }

        return response()->json($response, $statusCode);
    }
}