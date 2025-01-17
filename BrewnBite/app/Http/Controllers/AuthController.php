<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Account does not exist']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Invalid password details']);
        }

        session(['user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'membership' => $user->membership,
            'credit' => $user->credit,
            'total_spent' => $user->total_spent,
            'profile_picture' => $user->profile_picture ? asset('storage/' . $user->profile_picture) : null,
            'role' => $user->role,
        ]]);

        session(['cart' => []]);
        
        $checkRole = [
            1 => '/user',               
            2 => '/employee/dashboard', 
            3 => '/admin/dashboard',   
        ];

    
        if (isset($checkRole[$user->role])) {
            return redirect($checkRole[$user->role]);
        }
    
        return back()->withErrors(['role' => 'Invalid user role']);
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
            'confirm_password' => 'required|same:password'
        ]);
        
        $user = User::create([
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'name' => $request['name'],
            'role' => 1,
            'membership' => 0,
            'credit' => 0,
            'total_spent' => 0,
        ]);

        return redirect('/login')->with('success', 'Account created successfully');
    }

    public function logout(){
        session()->forget('user');
        return redirect('/login'); 
    }

}
