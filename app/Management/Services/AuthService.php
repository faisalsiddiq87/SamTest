<?php

namespace App\Management\Services;

use App\Models\User;
use App\Validations\AuthValidation;
use App\Management\Repositories\AuthRepository;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;

class AuthService 
{
    private $repository;

    private $validator;

    public function __construct()
    {
        $this->repository = new AuthRepository;

        $this->validator = new AuthValidation;
    }

   /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user) 
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + env('TOKEN_EXPIRY') // Expiration time
        ];
        
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
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
                $response = ['token' => $this->jwt($user)];
            } else {   
                $response = ['errors' => 'Passowrd is wrong for provided email.'];   
            }
        }

        return $response;
    }
}