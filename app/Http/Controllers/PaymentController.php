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

            return view('payments.index',[
                'priceToPay' => $this->paymentService->priceToPay,
                'productPrice' => $this->paymentService->price,
                'priceWithDiscount' => $this->paymentService->priceToPayWithDiscount,
                'priceWithVat' => $this->paymentService->priceWithVat,
            ]);
    }

}
