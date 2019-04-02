<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Management\Services\OrderService;

class OrderController extends Controller
{
    private $service;

    private $user;

    private $request;

    public function __construct(Request $request)
    {
        $this->user = $request->auth;
        
        $this->service = new OrderService;

        $this->request = $request;
    }

    public function getAllOrders()
    {
        return $this->response($this->service->getAllOrders($this->request));
    }

    public function createOrder(Request $request)
    {
        return $this->response($this->service->createOrder($this->request, $this->user));
    }

    public function cancelOrder($id, Request $request)
    {
        return $this->response($this->service->cancelOrder($id));
    }
   
    public function checkOrderStatus($id, Request $request)
    {
        return $this->response($this->service->checkOrderStatus($id));
    }

}