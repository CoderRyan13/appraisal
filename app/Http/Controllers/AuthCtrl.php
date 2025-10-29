<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Auth;

class AuthCtrl extends Controller
{
    // Register User
    public function register(Request $request) {
        // Validate
        $fields = $request->validate([
            'username' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'min:3', 'confirmed'],
        ]);
        
        // Register
        $user = User::create($fields);

        // Login
        Auth::login($user);
        
        //Redirect
        if(Auth::user()->username == 'admin') { return redirect('/appraisal/admin'); } else { return redirect('/appraisal/supervisor'); }
        // return redirect()->intended();
    }

    // Login User
    public function login(Request $request) {
        // Validate
        $fields = $request->validate([
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required', 'min:3'],
        ]);

        // Try to login the user
        if(Auth::attempt($fields, $request->remember)) {
            // return redirect()->intended();
            if(Auth::user()->username == 'admin') { return redirect('/appraisal/admin'); } else { return redirect('/appraisal/supervisor'); }
            
        }  else {
            return back()->withErrors([
                'failed' => 'The provided credentials do not match our records.'
            ]);
        } 
    }

    // Logout user
    public function logout(Request $request) {
        // Logout the user
        Auth::logout();

        // Invalidate user's session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Redirect to home
        return redirect('/login');
    }
}
