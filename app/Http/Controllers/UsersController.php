<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Schedule;




class UsersController extends Controller
    {   
        public function authenticate(Request $request)
        {
            $formFields = $request->validate([
                'email' => ['required', 'email'],
                'password' => 'required',
            ]);
            
            if (auth()->attempt($formFields)) {          
                return redirect('/dashboard')->with('message', 'You are logged in');
            } 
            
        
            return back()->withErrors(['email' => 'Invalid Credentials']);
        }
        public function logout(Request $request)
        {
            Auth::logout(); // Log out the user
            
            $request->session()->invalidate(); // Invalidate the session
            $request->session()->regenerateToken(); // Regenerate the CSRF token
        
            return redirect('/')->with('message', 'You have been logged out');
        }
        
        public function register(Request $request)
        {
            // Validate the user's input
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);
    
            // Create the user
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
    
            // Redirect the user after registration
            return redirect('/dashboard');
        }

        public function dashboard()
        {   
            return view('/dashboard.index', );
        }
        public function edit()
{   
    $schedule = Schedule::findOrFail(1);
    return view('dashboard.schedule.index', compact('schedule'));
}
}
