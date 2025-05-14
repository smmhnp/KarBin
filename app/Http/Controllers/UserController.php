<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends ApiController
{
    //................................................login..............................

    public function login(){
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('users/login');
    }

    public function loginSubmit(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required | email',
            'password' => 'required | min:5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $emailHash = hash('sha256', $credentials['email']);
        $user = User::where('email_hash', $emailHash)->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['message' => 'ایمیل یا رمز عبور اشتباه است'])->withInput();
        }

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'ورود با موفقیت انجام شد');
    }

    
    //................................................register...........................

    public function create()
    {
        // if (!Auth::check()) {
        //     return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        // }

        // if (Auth::user()->role != 'admin'){
        //     return redirect()->route('dashboard');
        // }

        return view('users.register');
    }

    public function store(Request $request)
    {
        // if (!Auth::check()) {
        //     return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        // }

        // if (Auth::user()->role != 'admin'){
        //     return redirect()->route('dashboard');
        // }

        $validated = $request->validate([
            'firstname' => 'required | string | max:255',
            'lastname' => 'required | string | max:255',
            'nickname' => 'required | string | max:255 | unique:users,nickname',
            'role' => 'required | string | max:255',
            'unit' => 'required | string | max:255',
            'email' => 'required | email | max:255 | unique:users,email',
            'password' => 'required | confirmed | min:6',
        ]);

        $user = User::create([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'nickname' => $validated['nickname'],
            'role' => $validated['role'],
            'unit' => $validated['unit'],
            'email' => $validated['email'],
            'email_hash' => hash('SHA256', $validated['email']),
            'password' => Hash::make($validated['password']),
        ]);

        return view('users/login', ['message' => 'successfuly register!']);
    }


    //................................................logout.............................

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/users/login');
    }


    //................................................profile............................

    public function profile()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }

        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function change(Request $request)
    {
        if (!Auth::check()) {
            return back()->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }

        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_new_password' => 'required|same:new_password',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'رمز عبور فعلی نادرست است'])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'رمز عبور با موفقیت تغییر یافت');
    }
    

    //................................................admin..............................

    public function users(){
        $users = User::all();
        return view('users/admin', ['users' => $users]);
    }
}
