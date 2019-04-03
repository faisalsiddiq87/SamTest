<?php

namespace App\Management\Services;

use App\Models\User;
use App\Management\Validations\AuthValidation;
use App\Management\Repositories\AuthRepository;
use App\Management\Contracts\Service\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService implements Contract
{
    use GenerateTokeService;

    private $repository;

    private $validator;

    public function __construct()
    {
        $this->repository = new AuthRepository;

        $this->validator = new AuthValidation;
    }

    /**
     * Authenticate a user and return the token
     * 
     * @param  \App\User   $user 
     * @return mixed
     */
    public function authenticate($request) 
    {
        $response = $this->validator->validate($request);

        if ($response === true) {
            $user = $this->repository->findUserByEmail($request['email']);

            if (!$user) {
                $response = ['errors' => 'Email does not exist.'];   
            } else if (Hash::check($request['password'], $user->password)) {
                $response = ['token' => $this->jwtToken($user)];
            } else {   
                $response = ['errors' => 'Passowrd is wrong for provided email.'];   
            }
        }

        return $response;
    }
}