@extends('base.BaseFormat')
@section('content')

    <div class="container">
        <?php //flash('password_update'); ?>
        
        <h2><i class="fas fa-user-cog"></i>پروفایل و تنظیمات</h2>
        <div class="card profile-card" style="max-width: 600px;">

            <div class="text-center mb-5">
                <div class="user-avatar" style="width: 100px; height: 100px; font-size: 2.5rem; margin: 0 auto 20px auto; border: 3px solid var(--border-color-light);">
                    {{ (Auth::user()->firstname) }}
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px 30px;" class="mb-5">
                <div class="form-group mb-0">
                    <label for="profileNickname" class="form-label">نام مستعار</label>
                    <input type="text" class="form-control" id="profileNickname" value="{{ (Auth::user()->nickname) }}" disabled readonly>
                </div>
                <div class="form-group mb-0">
                    <label for="profileEmail" class="form-label">آدرس ایمیل</label>
                    <input type="email" class="form-control" id="profileEmail" value="{{ (Auth::user()->email) }}" disabled readonly>
                </div>
                <div class="form-group mb-0">
                    <label for="profileRole" class="form-label">نقش سازمانی</label>
                    <input type="text" class="form-control" id="profileRole" value="{{ (Auth::user()->role) }}" disabled readonly>
                </div>
                <div class="form-group mb-0">
                    <label for="profileDepartment" class="form-label">واحد</label>
                    <input type="text" class="form-control" id="profileDepartment" value="{{ (Auth::user()->unit) }}" disabled readonly>
                </div>
            </div>
            
            <hr class="my-5" style="border-top: 1px solid var(--border-color-light);">
            
            <form action="{{ route('change') }}" method="post">
                @csrf
                <h4 class="mb-4">تغییر رمز عبور</h4>

                 @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="currentPassword" class="form-label">رمز عبور فعلی</label>
                        <input name="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" id="currentPassword">
                    </div>

                    <div class="col-md-4">
                        <label for="newPassword" class="form-label">رمز عبور جدید</label>
                        <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPassword">
                    </div>

                    <div class="col-md-4">
                        <label for="confirmNewPassword" class="form-label">تکرار رمز جدید</label>
                        <input name="confirm_new_password" type="password" class="form-control @error('confirm_new_password') is-invalid @enderror" id="confirmNewPassword">
                    </div>
                </div>

                <div class="d-flex">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> ذخیره تغییرات</button>
                </div>
            </form>
        </div>
    </div>

@endsection