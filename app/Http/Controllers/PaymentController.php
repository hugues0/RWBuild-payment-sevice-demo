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
        $this->paymentService->calculatePriceToPay();

            dd($this->paymentService);
    }

}
