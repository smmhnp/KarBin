@extends('base.BaseFormat')
@section('content')

    <div class="container">
        <!-- Login Screen -->
        <div class="card login-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-lock"></i> ورود به حساب کاربری</h3>
            </div>

            <form action="{{ route('login.submit') }}" method="POST" novalidate>
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="loginEmail" class="form-label">آدرس ایمیل سازمانی</label>
                    <input name="email" type="email"  class="form-control @error('email') is-invalid @enderror"  id="loginEmail" placeholder="email@company.com" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="loginPassword" class="form-label">رمز عبور</label>
                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="loginPassword" placeholder="••••••••">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary w-100 mt-4">
                    <span>ورود </span>
                    <i class="fas fa-sign-in-alt"></i>
                </button>

        
                <div class="w-100 mt-4" style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">

                    <a href="{{ route('google_login') }}" style="display: flex; align-items: center; background-color: white; color: black; border: 1px solid #ccc; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                        <span>ورود با گوگل</span>   
                        <img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="Google Logo"
                            style="width: 20px; height: 20px; margin-right: 8px;">
                    </a>

                    <a href="{{ route('github_login') }}" style="display: flex; align-items: center; background-color: #333; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                        <span>ورود با گیت‌هاب</span>
                        <svg style="margin-right: 8px;" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                            <path
                                d="M8 0C3.58 0 0 3.58 0 8a8 8 0 0 0 5.47 7.59c.4.07.55-.17.55-.38 
                                0-.19-.01-.82-.01-1.49-2 .37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 
                                1.08.58 1.23.82.72 1.2 1.87.86 2.33.66.07-.52.28-.86.5-1.06-1.78-.2-3.64-.89-3.64-3.95 
                                0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82a7.6 7.6 0 0 1 2-.27c.68 
                                0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 
                                1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 
                                1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 
                                0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                        </svg>
                    </a>

                </div>
                
                <!-- cloudflare -->
                 <div class="mt-4">
                    <x-turnstile-widget theme="light" language="fa"/>
                    @error('cf-turnstile-response')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Forgot Password -->
                <div class="text-center mt-4"> 
                    <small><a href="#">بازیابی رمز عبور</a></small> 
                </div>
                
            </form>
            
        </div>
    </div>

@endsection
