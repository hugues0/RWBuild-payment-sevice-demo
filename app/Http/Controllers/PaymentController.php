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
                'productPrice' => $this->paymentService->price,
                'priceWithDiscount' => $this->paymentService->priceToPayWithDiscount,
                'VAT' => $this->paymentService->priceWithVat,
                'priceToPay' => $this->paymentService->priceToPay,
            ];

            dd($bill);

    }

}
