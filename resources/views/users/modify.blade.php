@extends('base.BaseFormat')
@section('content')

    <div class="card login-card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user-plus"></i> ویرایش کاربر</h3>
        </div>

         @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
        @endif

        <form action="{{ route('modify', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="firstname">نام</label>
                <input type="text" name="firstname" id="firstname" class="form-control" value="{{ old('firstname', $user -> firstname) }}" required>
            </div>

            <div class="form-group">
                <label for="lastname">نام خانوادگی</label>
                <input type="text" name="lastname" id="lastname" class="form-control" value="{{ old('lastname', $user -> lastname) }}" required>
            </div>

            <div class="form-group">
                <label for="nickname">نام مستعار</label>
                <input type="text" name="nickname" id="nickname" class="form-control" value="{{ old('nickname', $user -> nickname) }}" required>
            </div>

            <div class="form-group">
                <label for="role">نقش کاربر</label>
                <input type="text" name="role" id="role" class="form-control" value="{{ old('role', $user -> role) }}" required>
            </div>

            <div class="form-group">
                <label for="unit">واحد</label>
                <input type="text" name="unit" id="unit" class="form-control" value="{{ old('unit', $user -> unit) }}" required>
            </div>

            <div class="form-group">
                <label for="email">ایمیل</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user -> email) }}" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">ثبت</button>
        </form>
    </div>

@endsection
