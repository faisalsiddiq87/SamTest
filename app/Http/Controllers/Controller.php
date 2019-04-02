<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function response($data, $type = "get") 
    {
        if (!empty($data['errors'])) {
            $response = ['status' => 0, 'data' => [], 'errors' => $data['errors']];
        } else {
            $data = is_object($data) ? $data->toArray() : $data;
            
            $response = ['status' => count($data) ? 1 : 0, 'data' => $data];
        }

        return response()->json($response, 200);
    }
}