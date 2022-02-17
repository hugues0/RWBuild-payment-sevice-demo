<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RwandaBuild\MurugoAuth\Facades\MurugoAuth;

class MurugoLoginController extends Controller
{
    public function redirectToMurugo()
    {
        return MurugoAuth::redirect();
    }

    
    public function murugoCallback()
    { 
        $murugoUser = MurugoAuth::user();
        dd($murugoUser);
    }
}
