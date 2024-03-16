<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|confirmed'
        ]);
        
        $user = new User([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password)
        ]);

        $user->save();

        return response()->json([
            'Successful'=>true,
            'Message'=>'User registered sucessfully.'
        ], 201);
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|string',
        ]);

        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials)){
            return response()->json([
                'Successful'=>false,
                'Message'=>'Wrong e-mail or password.'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->accessToken;

        return response()->json([
            'Successful'=>true,
            'Message'=>'User logged in.',
            'Access_Token'=>$token,
            'Token_Type'=>'Bearer'
        ]);
    }
}
