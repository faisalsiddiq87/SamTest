<?php

namespace App\Management\Repositories;

use App\Models\User;

class AuthRepository 
{
    public function findUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

}