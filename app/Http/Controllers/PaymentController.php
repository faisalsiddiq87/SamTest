<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Management\Services\PaymentService;

class PaymentController extends Controller
{
    private $service;

    private $user;

    private $request;

    public function __construct(Request $request)
    {
        $this->user = $request->auth;
        
        $this->service = new PaymentService;

        $this->request = $request;
    }

    public function processPayment()
    {
        return $this->response($this->service->processPayment($this->request->all(), $this->user));
    }
}