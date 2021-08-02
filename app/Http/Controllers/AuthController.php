<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields= $request->validate(
            [
                'name'=>'required|string',
                'email'=>'required|email|string|unique:users,email',
                'password'=>'required|string|confirmed',
            ]
            );
        $user = User::create([
            'name'=> $fields['name'],
            'email'=> $fields['email'],
            'password'=> $fields['password'],
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user'=> $user,
            'token'=> $token
        ];
        return response($response,201);
    }
    public function login(Request $request)
    {
        $fields= $request->validate(
            [
                'email'=>'required|email|string',
                'password'=>'required|string',
            ]
            );
        // Check email
        $user = User::where('email',$fields['email'])->first(); 
        // Check password
        if(!$user || ($fields['password']!= $user->password)){
            return response(
                [
                'message'=> "Bad credential",
                ]
            ,401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user'=> $user,
            'token'=> $token
        ];
        return response($response,201);
    }
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message'=>'LoggedOut'
        ];
    }
}
