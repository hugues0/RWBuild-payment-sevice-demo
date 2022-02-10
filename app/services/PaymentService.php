<?php

namespace App\Services;

class PaymentService{

    public  $price;
    
    public  $vatValue;

    public  $couponValue;

    public  $priceToPay;

    public $priceToPayWithDiscount;

    public $priceWithVat;

    
    public function __construct()
    {
        $this->price=config('services.products');
        $this->vatValue=config('services.vat');
        $this->couponValue=config('services.coupon');
    }

    /**
     * set the originall price @param price
     */
    public function setPrice($price)
    {
        $this->price=$price;
        return $this;
    }
    
    /**
     * index function to do all the computation and return  it to controller
     */
    public function priceToPayCalculator()
    {
        $this->priceToPayWithDiscount = $this->computeCouponDiscount($this->price);
        $this->vatCalculator();
        
        return $this->priceToPay;            
    }

    /**
     *calculate the VAT (value added tax) 
     */ 
    public function  vatCalculator(){
        if($this->vatValue['value']) {
         $this->priceWithVat  += ($this->priceToPayWithDiscount * $this->vatValue['value']);
         $this->priceToPay = $this->priceToPayWithDiscount + $this->priceWithVat;
        }
        return $this;
    }

    /**
     * calculate a discount at 5% @param price
     */
    public function computeCouponDiscount($price)
    {
        if(!$this->couponValue) return $price;

        return $price-($price * $this->couponValue['value']);
        
    }

}

