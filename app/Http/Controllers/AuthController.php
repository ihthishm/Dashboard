<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function getLogin(){
        $pass = "123456";
        $passhash = Hash::make($pass);
        echo $passhash;
        return view('admin.login');
    }

public function postLogin(Request $request){
    $request->validate([
        'email' =>'required|email',
        'password'=>'required'
    ]);
    $validated=auth()->attempt([
        'email'=>$request->email,
        'password'=>$request->password,
        'is_admin'=>1
    ],$request->password);

    if($validated){
        return redirect()->route('dashboard')->with('success','Login Successfull');
    }else{
        return redirect()->back()->with('error','Invalid credentials');
    }
}
}
