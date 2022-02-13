<?php

namespace App\Services;

use App\Models\Configuration;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoyaltyService{

    public $amountToPay;

    public $loyaltyPoints;

    public $pointsValue;

    public $user;

    public function __construct($amountToPay)
    {
        $this->amountToPay = $amountToPay;
        $this->loyaltyPoints = Auth::user()->points;
        $this->pointsValue = Configuration::where('name','points_value')->pluck('value')->first();
        $this->user=Auth::user()->id;
    }

    public function priceWithLoyaltyPoints()
    {
        if($this->loyaltyPoints >=10){
            $this->amountToPay -= $this->pointsValue;
            $this->loyaltyPoints -= 10;
            User::where('id',$this->user)->update(array('points'=>$this->loyaltyPoints));
        }
        return $this;
    }

    public function awardPoint(){
        if($this->amountToPay >=3000){
            $this->loyaltyPoints +=1;
            User::where('id',$this->user)->update(array('points'=>$this->loyaltyPoints));
        }
        return $this;
    }
}