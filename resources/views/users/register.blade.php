@extends('base.BaseFormat')
@section('content')

    <div class="card login-card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user-plus"></i> ثبت‌نام کاربر جدید</h3>
        </div>

        @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="firstname">نام</label>
                <input type="text" name="firstname" id="firstname" class="form-control" value="{{ old('firstname') }}" required>

            <div class="form-group">
                <label for="lastname">نام خانوادگی</label>
                <input type="text" name="lastname" id="lastname" class="form-control" value="{{ old('lastname') }}" required>
            </div>

            <div class="form-group">
                <label for="nickname">نام مستعار</label>
                <input type="text" name="nickname" id="nickname" class="form-control" value="{{ old('nickname') }}" required>
            </div>

            <div class="form-group">
                <label for="role">نقش کاربر</label>
                <input type="text" name="role" id="role" class="form-control" value="{{ old('role') }}" required>
            </div>

            <div class="form-group">
                <label for="unit">واحد</label>
                <input type="text" name="unit" id="unit" class="form-control" value="{{ old('unit') }}" required>
            </div>

            <div class="form-group">
                <label for="email">ایمیل</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">رمز عبور</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">تکرار رمز عبور</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">ثبت‌نام</button>
        </form>
    </div>

@endsection
