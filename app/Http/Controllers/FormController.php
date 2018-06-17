<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\User;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function login(LoginFormRequest $request){
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            Auth::login(User::where('email', '=', $request->email));
            return redirect('/');
        }
        return redirect()->back()->withErrors('Invalid email/password combination.');
    }

    public function register(RegisterFormRequest $request){
        $user = new User([
            'email' => $request->email,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'course_year' => $request->course_year,
            'reg_no' => substr($request->email, 0, 10),
            'branch' => substr($request->email, strpos($request->email, '@') - 5, 2),
            'password' => bcrypt($request->password),
        ]);

        $user->save();

        return redirect()->back()->with('message', 'Successfully registered. ');
    }
}
