<?php

namespace App\Validations;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class PaymentValidation
{
    public function validate($inputs) 
    {
        $rules = [
            'order_id' => 'required|integer|exists:orders_products,order_id',
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