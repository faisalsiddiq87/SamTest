<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Management\Services\AuthService;

class AuthController extends Controller 
{
    private $request;

    private $service;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->service = new AuthService;
    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * 
     * @return mixed
     */
    public function authenticate() 
    {
        return $this->response($this->service->authenticate($this->request->all()));
    }
}