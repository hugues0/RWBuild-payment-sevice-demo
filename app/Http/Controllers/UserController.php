<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;


class UserController extends Controller
{
    public function update(UserRequest $request,User $user)
    {
        $this->authorize('update',$user);
        $user->update($request->validated());
    }
}
