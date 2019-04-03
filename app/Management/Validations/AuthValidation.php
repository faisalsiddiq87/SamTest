<?php

namespace App\Management\Validations;

use App\Management\Contracts\Validation\Contract;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class AuthValidation implements Contract
{
    public function validate($inputs) 
    {
        $rules = [
            'email' => 'required|email',
            'password'  => 'required'
        ];

        $validator = Validator::make($inputs, $rules);

        $response = true;

        if ($validator->fails()) {
            $response = ['errors' => $validator->errors()];
        }

        return $response;
    }
}