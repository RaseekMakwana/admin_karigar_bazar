<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function login(){
        return view('authentication.login');
    }

    public function verification(Request $request){
        $input = $request->input();

        $request->session()->flush();
        if($input['username'] == "1" && $input['password'] == "1"){
            $session_data = array(
                "login_status" => "1",
            );
            $request->session()->put($session_data);
            return redirect()->intended('dashboard');
        } else {
            return redirect("/")->with('error_message', 'Invalid Username and Password');
        }
    }

    public function logout(Request $request) {
        $request->session()->flush();
        return redirect('/');
    }
    
}
