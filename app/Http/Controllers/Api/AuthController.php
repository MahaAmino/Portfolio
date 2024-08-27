<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $result=$request->validate([
            'email'=>'required|email|string',
            'password'=>'required|string|min:8',
            ]);
            $user=User::where('email',$result['email'])->first();
            if(!$user || !Hash::check($result['password'],$user->password)){
                return  response()->json(['message'=>'Not Found'],404);
            }
            $token=$user->createToken($user->name .'-authToken')->plainTextToken;
                return response()->json(['token'=>$token],200);

    }
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json(['message'=>'well done'],200);
    }
}
