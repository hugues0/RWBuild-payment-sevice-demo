<?php

namespace App\Services;

use App\Models\Configuration;
use App\Models\Product;
use Auth;



class PaymentService{

    public LoyaltyService $loyaltyService;
    
    public  $startPrice;
    
    public  $vat;

    public  $vatAmount;

    public  $coupon;

    public  $discount;

    public  $discountAmount;

    public  $discountedPrice;

    public  $transactionFee;

    public  $amountToPay;

    
    public function __construct()
    {
        $this->startPrice=Product::where('id',1)->pluck('price')->first();
        $this->vat=Configuration::where('name','vat')->pluck('value')->first();
        $this->coupon=Configuration::where('name','coupon')->pluck('value')->first();
        $this->discount=Configuration::where('name','discount')->pluck('value')->first();
        $this->transactionFee=Configuration::where('name','transaction_fee')->pluck('value')->first();
        $this->discountAmount=0;
        $this->discountedPrice=0;
        $this->amountToPay=0;
    }

    
    public function calculatePriceToPay()
    {
        $this
            ->priceWithvatAmountCalculator()
            ->priceWithdiscountCalculator()
            ->priceWithTransactionFee()
            ->priceWithCouponCalculator();
        $this->loyaltyService = new LoyaltyService($this->amountToPay);
        $this->loyaltyService
            ->priceWithLoyaltyPoints()
            ->awardPoint();
        $this->amountToPay = $this->loyaltyService->amountToPay;
        return $this;
    }

    /**
     * this function calculates the price to pay with VAT added
     */

    public function priceWithvatAmountCalculator()
    {
        $this->vatAmount = $this->startPrice * $this->vat;
        $this->amountToPay = $this->startPrice + $this->vatAmount;
        return $this;
    }

    /**
     * this function calculates the amount to pay if logged in user is a member
     */

    public function priceWithdiscountCalculator()
    {
        if(Auth::user()->is_member){
            $this->discountedPrice = $this->amountToPay - ($this->amountToPay * $this->discount);
            $this->discountAmount= $this->amountToPay - $this->discountedPrice;
            $this->amountToPay -= $this->discountAmount;
        }
        $this->discountedPrice=$this->amountToPay;
        return $this;
    }

    /**
     * this function adds transaction fee from amount to pay
     */
    public function priceWithTransactionFee()
    {
        $this->amountToPay += $this->transactionFee;
        return $this;
    }


    /**
     * this function calculates the amount to pay with coupon discount
     */
    public function priceWithCouponCalculator()
    {
        if($this->coupon){
            $this->amountToPay =$this->amountToPay - ($this->amountToPay * $this->coupon);
        }
        return $this;
    }

}

