<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Coderflex\LaravelTurnstile\Rules\TurnstileCheck;
use Coderflex\LaravelTurnstile\Facades\LaravelTurnstile;



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

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'cf-turnstile-response' => 'required',
        ], [
            'email.required' => 'وارد کردن ایمیل الزامی است.',
            'email.email' => 'فرمت ایمیل وارد شده معتبر نیست.',
            'password.required' => 'رمز عبور الزامی است.',
            'password.min' => 'رمز عبور باید حداقل :min کاراکتر باشد.',
            'cf-turnstile-response.required' => 'لطفاً کپچا را تکمیل کنید.',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

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
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }

        if (Auth::user()->role != 'super_admin'){
            return redirect()->route('dashboard');
        }

        return view('users.register');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }

        if (Auth::user()->role != 'super_admin'){
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'nickname' => 'required|string|max:255|unique:users,nickname',
            'role' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ], [
            'firstname.required' => 'نام کوچک را وارد کنید.',
            'firstname.string' => 'نام کوچک باید متنی باشد.',
            'firstname.max' => 'نام کوچک نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

            'lastname.required' => 'نام خانوادگی را وارد کنید.',
            'lastname.string' => 'نام خانوادگی باید متنی باشد.',
            'lastname.max' => 'نام خانوادگی نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

            'nickname.required' => 'نام مستعار را وارد کنید.',
            'nickname.string' => 'نام مستعار باید متنی باشد.',
            'nickname.max' => 'نام مستعار نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',
            'nickname.unique' => 'نام مستعار قبلاً استفاده شده است.',

            'role.required' => 'نقش را وارد کنید.',
            'role.string' => 'نقش باید متنی باشد.',
            'role.max' => 'نقش نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

            'unit.required' => 'واحد را وارد کنید.',
            'unit.string' => 'واحد باید متنی باشد.',
            'unit.max' => 'واحد نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

            'email.required' => 'ایمیل را وارد کنید.',
            'email.email' => 'فرمت ایمیل صحیح نیست.',
            'email.max' => 'ایمیل نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',

            'password.required' => 'رمز عبور را وارد کنید.',
            'password.confirmed' => 'تأیید رمز عبور با رمز عبور مطابقت ندارد.',
            'password.min' => 'رمز عبور باید حداقل ۶ کاراکتر باشد.',
        ]);


        User::create([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'nickname' => $validated['nickname'],
            'role' => $validated['role'],
            'unit' => $validated['unit'],
            'email' => $validated['email'],
            'email_hash' => hash('SHA256', $validated['email']),
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.all')->with('success', 'کاربر با موفقیت اضافه شد');
    }


    //................................................modify............................

     public function modify($id){
        if (Auth::user()->role != 'super_admin'){
            return redirect()->route('dashboard');
        }

        $user = User::findOrFail($id);

        return view('users.modify', ['user' => $user]);
    }

    public function modifySubmit(Request $request, $id)
    {
        if (Auth::user()->role != 'super_admin'){
            return redirect()->route('dashboard');
        }

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'firstname' => 'required | string | max:255',
            'lastname' => 'required | string | max:255',
            'nickname' => 'required | string | max:255 | unique:users,nickname,' . $id,
            'role' => 'required | string | max:255',
            'unit' => 'required | string | max:255',
            'email' => 'required | email | max:255 | unique:users,email,' . $id,
        ], [
            'firstname.required' => 'نام کوچک را وارد کنید.',
            'firstname.string' => 'نام کوچک باید متنی باشد.',
            'firstname.max' => 'نام کوچک نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

            'lastname.required' => 'نام خانوادگی را وارد کنید.',
            'lastname.string' => 'نام خانوادگی باید متنی باشد.',
            'lastname.max' => 'نام خانوادگی نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

            'nickname.required' => 'نام مستعار را وارد کنید.',
            'nickname.string' => 'نام مستعار باید متنی باشد.',
            'nickname.max' => 'نام مستعار نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',
            'nickname.unique' => 'نام مستعار قبلاً استفاده شده است.',

            'role.required' => 'نقش را وارد کنید.',
            'role.string' => 'نقش باید متنی باشد.',
            'role.max' => 'نقش نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

            'unit.required' => 'واحد را وارد کنید.',
            'unit.string' => 'واحد باید متنی باشد.',
            'unit.max' => 'واحد نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

            'email.required' => 'ایمیل را وارد کنید.',
            'email.email' => 'فرمت ایمیل صحیح نیست.',
            'email.max' => 'ایمیل نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',

            'password.required' => 'رمز عبور را وارد کنید.',
            'password.confirmed' => 'تأیید رمز عبور با رمز عبور مطابقت ندارد.',
            'password.min' => 'رمز عبور باید حداقل ۶ کاراکتر باشد.',
        ]);

        $user->update([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'nickname' => $validated['nickname'],
            'role' => $validated['role'],
            'unit' => $validated['unit'],
            'email' => $validated['email'],
            'email_hash' => hash('SHA256', $validated['email']),
        ]);

        return redirect()->route('users.all')->with('success', 'کاربر با موفقیت ویرایش شد');
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
            'new_password' => 'required|min:6',
            'confirm_new_password' => 'required|same:new_password',
        ], [
            'current_password.required' => 'وارد کردن رمز عبور فعلی الزامی است.',
            'new_password.required' => 'وارد کردن رمز عبور جدید الزامی است.',
            'new_password.min' => 'رمز عبور جدید باید حداقل ۶ کاراکتر باشد.',
            'confirm_new_password.required' => 'تأیید رمز عبور جدید الزامی است.',
            'confirm_new_password.same' => 'تأیید رمز عبور جدید با رمز عبور جدید مطابقت ندارد.',
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

        return redirect()->route('dashboard')->with('success', 'رمز عبور با موفقیت تغییر یافت');
    }
    

    //................................................admin..............................

    public function users(){
        if (!isset(Auth::user()->role)){
            return redirect()->route('dashboard');
        }

        if (Auth::user()->role != 'super_admin'){
            return redirect()->route('dashboard');
        }

        $users = User::all();
        return view('users/admin', ['users' => $users]);
    }


    public function google_login(){
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
