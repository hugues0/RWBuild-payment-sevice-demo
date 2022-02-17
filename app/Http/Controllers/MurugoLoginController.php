<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use RwandaBuild\MurugoAuth\Facades\MurugoAuth;
use App\Models\User;
use RwandaBuild\MurugoAuth\Models\MurugoUser;

class MurugoLoginController extends Controller
{
    /**
     * this funciton redirects user to logging in with murugo cloud
     */
    public function redirectToMurugo()
    {
        return MurugoAuth::redirect();
    }

    /**
     * A callback function that gets called after murugo user is authenticated
     */
    public function murugoCallback()
    { 
        $murugoUser = MurugoAuth::user();
        $user=$murugoUser->user; // check id murugo user is in my app database
        if(!$user){
            $user=$murugoUser->user()->create([ //if user not in our database we create him/her from the murugo user relationship
                'name'=> $murugoUser->name,
            ]);
            $user->attachRole(Role::IS_USER);
        }

        Auth::login($user); //login user in our app 
        return redirect()->route('payments'); // redirects logged in user on payments route 
    }
}
