<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\loginRequest;
use App\Http\Requests\modifyRequest;
use App\Http\Requests\profileRequest;
use App\Http\Requests\registerRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;



class UserController extends ApiController
{
    //................................................login..............................

    public function login(){
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('users/login');
    }

    public function loginSubmit(loginRequest $request)
    {
        $emailHash = hash('sha256', $request->email);
        $user = User::where('email_hash', $emailHash)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['message' => 'ایمیل یا رمز عبور اشتباه است'])->withInput();
        }

        if ($user['status'] == 'inactive'){
            return back()->withErrors(['message' => 'کاربر غیر فعال است'])->withInput();
        }

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'ورود با موفقیت انجام شد');
    }

    
    //................................................register...........................

    public function create()
    {
        if (Auth::user()->role != 'super_admin'){
            return redirect()->route('dashboard');
        }

        return view('users.register');
    }

    public function store(registerRequest $request)
    {
        if (Auth::user()->role != 'super_admin'){
            return redirect()->route('dashboard');
        }

        User::create([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'nickname' => $request['nickname'],
            'role' => $request['role'],
            'unit' => $request['unit'],
            'email' => $request['email'],
            'email_hash' => hash('SHA256', $request['email']),
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->route('users.all')->with('success', 'کاربر با موفقیت اضافه شد');
    }


    //................................................modify............................

    public function modify($id)
    {
        $user = User::findOrFail($id);

        return view('users.modify', ['user' => $user]);
    }

    public function modifySubmit(modifyRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'nickname' => $request['nickname'],
            'role' => $request['role'],
            'unit' => $request['unit'],
            'email' => $request['email'],
            'email_hash' => hash('SHA256', $request['email']),
        ]);

        return redirect()->route('users.all')->with('success', 'کاربر با موفقیت ویرایش شد');
    }


    //................................................logout.............................

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/users/login');
    }


    //................................................profile............................

    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function change(profileRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()
                ->withErrors(['current_password' => 'رمز عبور فعلی نادرست است'])
                ->withInput();
        }

        
        Auth::user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('dashboard')->with('success', 'رمز عبور با موفقیت تغییر یافت');
    }
    

    //................................................admin..............................

    public function users()
    {
        if (!isset(Auth::user()->role)){
            return redirect()->route('dashboard');
        }

        if (Auth::user()->role != 'super_admin'){
            return redirect()->route('dashboard');
        }

        $users = User::all();
        return view('users/admin', ['users' => $users]);
    }

    //................................................login.with.google..................

    public function google_login(Request $request){
        return Socialite::driver('google')->redirect();
    }

    public function login_with_google(){
        $googleUser = Socialite::driver('google')->stateless()->user();

        $current_user = User::where('email_hash', hash('sha256', $googleUser->getEmail()))->first();

        if (!$current_user) {
            $current_user = User::create([
                'firstname' => $googleUser->user['given_name'],
                'lastname' => $googleUser->user['family_name'],
                'nickname' => $googleUser->nickname ?? $googleUser->user['given_name'],
                'role' => 'user',
                'unit' => 'dev',
                'email' => $googleUser->getEmail(),
                'email_hash' => hash('sha256', $googleUser->getEmail()),
                'password' => Hash::make(Str::random(16)), 
            ]);
        }
        
        Auth::login($current_user);

        return redirect('/dashboard');
    }


    //................................................login.with.github..................

    public function github_login(){
        return Socialite::driver('github')->redirect();
    }

    public function login_with_github(){
        $githubuser = Socialite::driver('github')->stateless()->user();

        $current_user = User::where('email_hash', hash('sha256', $githubuser->getEmail()))->first();

        if (!$current_user) {
            $current_user = User::create([
                'firstname' => $githubuser->user['given_name'],
                'lastname' => $githubuser->user['family_name'],
                'nickname' => $githubuser->nickname ?? $githubuser->user['given_name'],
                'role' => 'user',
                'unit' => 'dev',
                'email' => $githubuser->getEmail(),
                'email_hash' => Hash::make($githubuser->getEmail()),
                'password' => Hash::make(Str::random(8)), 
            ]);
        }
        
        Auth::login($current_user);

        return redirect('/dashboard');
    }

    
    //................................................done...............................

    public function status(Request $request, $id){
        $user = User::findOrFail($id);

        $user->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->route('users.all')->with('success', 'وضعیت کاربر به‌روزرسانی شد');
    }
}
