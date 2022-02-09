<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{


    public function __construct()
    {
        $this->user= config('services.members');
        $this->product= config('services.products');
        $this->user= config('services.members');
    }   
        

    public function index()
    {
        $user=$this->user["name"];
        $price=$this->product["price"];
        $priceWithVat = $this->vatCalculator($this->product["price"]);
        $userHasCoupon = $this->couponCalculator($this->user["name"],$this->product["price"]);
        $priceToPay = $priceWithVat - ($price - $userHasCoupon);
        $bill = [
            'user' => $user,
            'price' => $price,
            'price with vat' => $priceWithVat,
            'price with coupon' => $userHasCoupon,
            'price to pay' => $priceToPay,
        ];

        dd($bill);
    }

    /* public function storePurchase($statement)
    {
      Cache::put('purchase',$statement);
    } 
 */

    public function vatCalculator($price)
    {
        return $newPrice = $price + ($price * 18/100);
    }

    public function couponCalculator($user,$price)
    {
        if(in_array($user,$this->user)) {
            $newPrice = $price - (($price * 5) /100);
            return $newPrice;
        }
        return $price;
    }

}
