<?php

use App\Models\User;
use App\Management\Services\GenerateTokeService;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PaymentTest extends TestCase
{
    use GenerateTokeService;
    
    /**
     * api/v1/payment [POST]
    */
    public function testShouldCreateOrders()
    {
        $this->post('api/v1/payment', ['order_id' => 1, 'amount' => 440.20], $this->jwtToken(User::find(1), false));
    
        $this->seeStatusCode(200);
    
        $this->seeJsonStructure([
            'data' => [
                'created_by',
                'status',
                'order_id',
                'amount',
                'updated_at',
                'created_at',
                'id'
            ]
        ]);
    }

  }