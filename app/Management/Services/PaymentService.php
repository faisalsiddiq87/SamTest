<?php

namespace App\Management\Services;

use App\Management\Validations\PaymentValidation;
use App\Management\Repositories\PaymentRepository;
use App\Management\Contracts\Service\Contract;

class PaymentService implements Contract
{
    private $repository;

    private $validator;

    public function __construct()
    {
        $this->repository = new PaymentRepository;

        $this->validator = new PaymentValidation;
    }

    public function processPayment($request, $user)
    {
        $request['created_by'] = $user->id;

        $response = $this->validator->validate($request);

        if ($response === true) {
            try {
                $paymentDone = $this->repository->checkIfOrderAlreadyPayed($request['order_id']);

                if (!$paymentDone) {
                    $check = $this->verifyOrderPayment($request);
                    
                    if ($check['status']) {
                        $response = $this->insertPayment($request, PaymentRepository::PAYMENT_CONFIRMED_STATUS);
                    } else {
                        $this->insertPayment($request, PaymentRepository::PAYMENT_DECLINED_STATUS);

                        $response = ['errors' => "Payed Amount (" . $request['amount'] . ") not equal to order products price (". $check['products_price'] . ")"];   
                    }
                } else {
                    $response = $paymentDone;
                }
            } catch (\Exception $e) {
                $response = ['errors' => $e->getMessage()];
            }
        }

        return $response;
    }

    private function verifyOrderPayment($request)
    {
        $orderId = $request['order_id'];

        $payedAmount = $request['amount'];

        $priceVerified = false;

        $orderProductPrice = $this->repository->getProductPrice($orderId);

        $productsPrice = !empty($orderProductPrice->products_price) ? $orderProductPrice->products_price : 0;

        if ($payedAmount == $orderProductPrice->products_price) {
            $priceVerified = true;
        }

        return ['status' => $priceVerified, 'products_price' => $productsPrice];
    }

    private function insertPayment($request, $status)
    {
        $request['status'] = $status;

        return $this->repository->processPayment($request);
    }
    
}