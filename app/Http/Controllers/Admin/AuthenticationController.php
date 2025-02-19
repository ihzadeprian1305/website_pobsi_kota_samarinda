<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function login(){
        return view('admin.auth.login');
    }

    public function checkLogin(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'email_or_username' => ['required'],
                'password' => ['required'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if(filter_var($request->email_or_username, FILTER_VALIDATE_EMAIL)){
                $credentialData = [
                    'email' => $request->email_or_username,
                    'password' => $request->password,
                ];
            } else {
                $credentialData = [
                    'username' => $request->email_or_username,
                    'password' => $request->password,
                ];
            }

            if(Auth::attempt($credentialData)){
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->back()->with('status', 'Email, Username, atau Password Salah');
            }
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }

    }

    public function logout(Request $request){
        try {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/admin/login');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }

    }
}
