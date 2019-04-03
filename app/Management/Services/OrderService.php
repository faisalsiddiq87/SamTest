<?php

namespace App\Management\Services;

use App\Helpers\RequestHelper;
use App\Management\Validations\OrderValidation;
use App\Management\Repositories\OrderRepository;
use App\Management\Contracts\Service\Contract;

class OrderService implements Contract
{
    private $repository;

    private $validator;

    public function __construct()
    {
        $this->repository = new OrderRepository;

        $this->validator = new OrderValidation;
    }

    public function getAllOrders($request)
    {    
        return $this->repository->getAllOrders();
    }

    public function cancelOrder($id)
    {
        return $this->repository->cancelOrder($id);
    }

    public function createOrder($request, $user)
    {
        $data = $request->all();

        $data['user_id'] = $user->id;

        $response = $this->validator->validate($data);

        if ($response === true) {
            $order = $this->repository->createOrder($data);

            if (!empty($order->id)) {
                $payment = RequestHelper::run($request, 'payment', 'POST', ['order_id' => $order->id, 'amount' => (float) $data['amount']]);
                
                if ($payment['status']) {
                    $order = $this->updateOrderStatus($order, OrderRepository::ORDER_CONFIRMED_STATUS);

                    $response = ['order_detail' => $order, 'payment_detail' => $payment['data']];
                } else {
                    $order = $this->updateOrderStatus($order, OrderRepository::ORDER_CANCELLED_STATUS);

                    $response = ['order_detail' => $order, 'payment_detail' => $payment['errors']];
                }
            }
        }

        return $response;
    }

    private function updateOrderStatus($order, $status)
    {
        return $this->repository->updateOrderStatus($order, $status);
    }

    public function checkOrderStatus($id)
    {
        $data = $this->repository->findStatusById($id);

        $response = [];

        if ($data) {
            $response = $this->statusLabel($data->status);
        }

        return $response;
    }

    public function statusLabel($status) 
    {
        $label = "";

        switch ($status) {
            case OrderRepository::ORDER_CREATED_STATUS: 
                $label = "Created";
                break;
            case OrderRepository::ORDER_CANCELLED_STATUS: 
                $label = "Cancelled";
                break;
            case OrderRepository::ORDER_DELIVERED_STATUS: 
                $label = "Delivered";
                break;
            case OrderRepository::ORDER_CONFIRMED_STATUS: 
                $label = "Confirmed";
                break;
            default:
                $label = "UnKnown";
        }

        return ['value' => $status, 'label' => $label];
    }
}