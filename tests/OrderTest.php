<?php

use App\Models\User;
use App\Management\Services\GenerateTokeService;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class OrderTest extends TestCase
{
    use GenerateTokeService;

    /**
     * api/v1/order [GET]
    */
    public function testShouldReturnAllOrders()
    {
        $this->get('api/v1/order', $this->jwtToken(User::find(1), false));
    
        $this->seeStatusCode(200);
    
        $this->seeJsonStructure([
            'data' => ['*' => [
                    'id',
                    'user_id',
                    'status',
                    'created_at',
                    'products'
                ]
            ]
        ]);
    }

    /**
     * api/v1/order/check-status/{id} [GET]
    */
    public function testShouldCheckOrderStatus()
    {
        $this->get('api/v1/order/check-status/1', $this->jwtToken(User::find(1), false));
    
        $this->seeStatusCode(200);
    
        $this->seeJsonStructure([
            'data' => [
                'value',
                'label'
            ]
        ]);
    }

    /**
     * api/v1/order/cancel-order/{id} [PUT]
    */
    public function testShouldCancelOrder()
    {   
        $this->put('api/v1/order/cancel-order/1', [], $this->jwtToken(User::find(1), false));
    
        $this->seeStatusCode(200);
    
        $this->seeJsonStructure([
            'data' => [
                'id',
                'user_id',
                'status'
            ]
        ]);
    }

    /**
     * api/v1/order/create [POST]
    */
    public function testShouldCreateOrders()
    {
        $this->post('api/v1/order/create', ['products' => [5, 6], 
        'amount' => 440.20], $this->jwtToken(User::find(1), false));
    
        $this->seeStatusCode(200);
    
        $this->seeJsonStructure([
            'data' => [
                'order_detail' ,
                'payment_detail'
            ]
        ]);
    }

  }