<?php

namespace App\Management\Repositories;

use App\Models\Order;
use App\Models\OrderProduct;

class OrderRepository 
{
    const ORDER_CREATED_STATUS = 1;

    const ORDER_CANCELLED_STATUS = 2;

    const ORDER_CONFIRMED_STATUS = 3;

    const ORDER_DELIVERED_STATUS = 4;

    public function getAllOrders()
    {
        return Order::with(['products.detail', 'creator'])->get();
    }

    public function findStatusById($id)
    {
        return Order::select('status')->where('id', $id)->first();
    }

    public function createOrder($orderData)
    {
        \DB::beginTransaction();

        try {
            $order = new Order;

            $order->user_id = $orderData['user_id'];

            $order->status = self::ORDER_CREATED_STATUS;

            $order->save();

            foreach ($orderData['products'] as $product) {
                $orderProduct = new OrderProduct;

                $orderProduct->order_id = $order->id;

                $orderProduct->product_id = $product;
                
                $orderProduct->save();
            }

            \DB::commit();

            $data = $order;
        } catch (\Exception $e) {
            $data = ['errors' => $e->getMessage()];

            \DB::rollback();
        }
        
        return $data;
    }

    public function updateOrderStatus($order, $status)
    {
        $order->status = $status;

        $order->save();

        return $order;
    }

    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);

        $order->status = self::ORDER_CANCELLED_STATUS;

        $order->save();

        return $order;
    }
}