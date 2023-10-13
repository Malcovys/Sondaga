<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SingUpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function singUp(SingUpRequest $request){

        $credential = $request->validated();
        $credential['password'] = Hash::make($credential['password']);

        User::create($credential);
    }

    public function auth(LoginRequest $request){
    
       $credentials = $request->validated();

       if(Auth::attempt($credentials)) {

        return Auth::User();

       };

       return [
        'authentificationError' => 'Nom ou mot de passe invalide',
       ];
    }
}
