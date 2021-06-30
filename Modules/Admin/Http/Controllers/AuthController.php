<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;
use App\Custom\RSP;

class AuthController extends Controller
{    
    public function login()
    {
        return RSP::view(["view_name" => "admin::auth.login"]);
    }
    
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $request->session()->flush();
        Auth::logout();

        return redirect('/admin/login');
    }

    public function loginAuth(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $request->user()->tokens()->delete();
            $token = $request->user()->createToken('spa')->plainTextToken;
            session(['personal-token' => $token]);
            return RSP::json([
                "redirect" => "/admin"
            ]);
        }
        else
        { 
            return RSP::json([
                "status" => 401,
                "message" => "Login ID or Password is invalid.",
                "errors" => [
                    "email" => ["Login ID maybe invalid."],
                    "password" => ["Password maybe invalid."],
                ]
            ]);
        }
    }
}
