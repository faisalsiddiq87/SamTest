<?php

namespace App\Management\Repositories;

use App\Models\User;
use App\Management\Contracts\Repository\Contract;

class AuthRepository implements Contract
{
    public function findUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

}