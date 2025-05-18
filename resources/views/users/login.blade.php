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

                <a href="{{ route('google_login') }}" class="google-btn w-100 mt-4">
                    <span>ورود با گوگل</span>
                    <img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="Google Logo">
                </a>
                
                <!-- Forgot Password -->
                <div class="text-center mt-4"> 
                    <small><a href="#">بازیابی رمز عبور</a></small> 
                </div>
            </form>
            
        </div>
    </div>

@endsection
