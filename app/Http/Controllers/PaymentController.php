<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    private $paymentService;

    public function __construct()
    {
        $this->paymentService = new PaymentService();
    }

    public function processPayment()
    {
        $this->paymentService
            ->setPrice(5000)
            ->priceToPayCalculator();

            $bill=[
                'product_price' => $this->paymentService->price,
                'price_with_discount' => $this->paymentService->priceToPayWithDiscount,
                'vat' => $this->paymentService->priceWithVat,
                'price_to_pay' => $this->paymentService->priceToPay,
            ];

            dd($bill);

    }

}
