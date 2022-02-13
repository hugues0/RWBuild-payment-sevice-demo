<?php

namespace App\Services;

use App\Models\Configuration;
use App\Models\User;
//use Auth;
use Illuminate\Support\Facades\Auth;

class LoyaltyService{

    public $amountToPay;

    public $loyaltyPoints;

    public $pointsValue;

    public function __construct($amountToPay)
    {
        $this->amountToPay = $amountToPay;
        $this->loyaltyPoints = Auth::user()->points;
        $this->pointsValue = Configuration::where('name','points_value')->pluck('value')->first();
    }

    public function priceWithLoyaltyPoints()
    {
        //dd($this);

        if($this->loyaltyPoints >=10){
            $this->amountToPay -= $this->pointsValue;
            $this->loyaltyPoints -= 10;
        }
        //dd($this);

        return $this;
    }

    public function awardPoint(){
        if($this->amountToPay >=2000){
            $this->loyaltyPoints +=1;
        }
        Auth::user()->update(['points'=>$this->loyaltyPoints]);
        return $this;
    }
}