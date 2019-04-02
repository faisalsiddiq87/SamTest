<?php

namespace App\Management\Repositories;

use App\Models\Payment;
use App\Models\OrderProduct;

class PaymentRepository 
{
    const PAYMENT_CONFIRMED_STATUS = 1;

    const PAYMENT_DECLINED_STATUS = 0;

    public function checkIfOrderAlreadyPayed($orderId) 
    {
        return Payment::where(['order_id' => $orderId, 'status'=> self::PAYMENT_CONFIRMED_STATUS])
        ->first();
    }

    public function processPayment($request)
    {
        $payment = new Payment;

        $payment->created_by = $request['created_by'];

        $payment->status = $request['status'];

        $payment->order_id = $request['order_id'];

        $payment->amount = $request['amount'];

        $payment->save();

        return $payment;
    }

    public function getProductPrice($orderId)
    {
        $orderProductsPrice = OrderProduct::select(\DB::raw('SUM(price) As products_price'))
        ->join('products', 'orders_products.product_id', 'products.id')
        ->where('order_id', $orderId)->groupBy('order_id')->first();

        return $orderProductsPrice;
    }

}