<?php

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    /**
     * api/v1/auth/login [POST]
    */
    public function testShouldCreateToken()
    {
        $this->post('api/v1/auth/login', ['email' => 'faisal.siddiq87+user02@gmail.com', 'password' => '123456']);
    
        $this->seeStatusCode(200);
    
        $this->seeJsonStructure([
            'data' => [
                'token'
            ]
        ]);
    }

  }