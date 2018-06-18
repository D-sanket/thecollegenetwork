<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function home(){
        return view('home');
    }

    public function timeline(){
        return view('timeline');
    }

    public function login(){
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    public function logout(){
        if(Auth::check()){
            Auth::logout();
            return redirect('/')->with('message', 'Successfully logged out.');
        }
        return redirect('/auth/login')->withErrors('You are not logged in.');
    }

    public function attendance(){
        return view('attendance');
    }
    public function results(){
        return view('results');
    }
    public function friends(){
        return view('friends');
    }
    public function clubs(){
        return view('clubs');
    }
    public function feedback(){
        return view('feedback');
    }
    public function appointments(){
        return view('appointments');
    }
    public function track(){
        return view('track');
    }
    public function confessions(){
        return view('confessions');
    }
    public function help(){
        return view('help');
    }

    public function profile($reg_no = null){
        $reg_no = $reg_no == null ? Auth::user()->reg_no : $reg_no;
        if($user = User::where('reg_no', '=', $reg_no)->first()) {
            return view('profile', compact('user'));
        }
        abort(404);
    }

}
