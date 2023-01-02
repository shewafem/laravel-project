<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('auth/registration');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' =>'required|email|unique:App\Models\User',
            'password' =>'required|min:6',
        ]);

        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->password = Hash::make(request('password'));
        $user->save();
        $user->createToken('myapptoken')->plainTextToken;
        return redirect()->route('login');
        // return response()->json($request);
    }

    public function login(){
        return view('auth.signin');
    }

    public function customLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);

        $user = User::where('email', request('email'))->first();
        $user->createToken('myAppToken');

    }

    public function signout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}