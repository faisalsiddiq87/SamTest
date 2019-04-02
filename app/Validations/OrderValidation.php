<?php

namespace App\Validations;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class OrderValidation
{
    public function validate($inputs) 
    {
        $rules = [
            'products' => 'required|array',
            'products.*' => 'integer|exists:products,id',
            'amount' => 'required|numeric'
        ];

        $validator = Validator::make($inputs, $rules);

        $response = true;

        if ($validator->fails()) {
            $response = ['errors' => $validator->errors()];
        }

        return $response;
    }
}