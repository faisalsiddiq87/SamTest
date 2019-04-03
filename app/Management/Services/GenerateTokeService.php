<?php

namespace App\Management\Services;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

trait GenerateTokeService 
{
     /**
     * Create a new token.
     * 
     * @return string
     */
    protected function jwtToken(User $user, $tokenOnly = true) 
    {
        $payload = [
            'iss' => 'lumen-jwt', // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + env('TOKEN_EXPIRY') // Expiration time
        ];
        
        $token = JWT::encode($payload, env('JWT_SECRET'));

        if ($tokenOnly) {
            return $token;
        } else {
            return ['Accept' => 'application/json', 'Authorization' =>  'Bearer ' . $token];
        }
    }
}