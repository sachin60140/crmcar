<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Hash;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {       
        if (!empty(Auth::check())) {
            return redirect('admin/dashboard');
        }
        return view('admin.login');
    }

    public function logout(Request $request): RedirectResponse
        {
            Session::flush();
            
            Auth::logout();

            $request->session()->invalidate();
        
            $request->session()->regenerateToken();
        
            return redirect('/admin');
        }

    public function authlogin(Request $req)
    {
        if (Auth::attempt(['email' => $req->email, 'password' => $req->password], true)) {
            return redirect('admin/dashboard');
        } else {
            return redirect()->back()->with('error', 'Email or password is incorrect');
        }
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function lead()
    {
        return view('admin.client');
    }
}
