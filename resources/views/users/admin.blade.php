@extends('base.BaseFormat')
@section('content')

    <div class="container">
    
        <?php //flash('register_success'); ?>

        <h2><i class="fas fa-users-cog"></i>مدیریت کاربران (ادمین)</h2>
        <div class="card">
            <div class="section-header">
                <h3 style="margin-bottom: 0;">لیست کاربران سیستم</h3>
                <a href="{{ route('register') }}" class="btn btn-info btn-sm"><i class="fas fa-user-plus"></i>عضویت کاربر جدید</a>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead> 
                        <tr> 
                            <th>نام و نام خانوادگی</th> 
                            <th>نام مستعار</th> 
                            <th>ایمیل</th> 
                            <th>نقش</th> 
                            <th>وضعیت</th> 
                            <th>تاریخ عضویت</th> 
                            <th>عملیات</th> 
                        </tr> 
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr> 
                                <td>{{ $user->firstname . " " . $user->lastname  }}</td> 
                                <td>{{ $user -> nickname }}</td> 
                                <td>{{ $user -> email }}</td> 
                                <td>{{ Role ($user -> role) }}</td> 
                                <td>
                                    <span class="badge badge-status-{{$user -> status}}">{{ status ($user -> status) }}</span>
                                </td> 
                                <td>{{ $user -> created_at -> toDateString() }}</td> 
                                <td>
                                    <div class="button-group">
                                        <a href="{{ route('modify', ['id' => $user->id]) }}" class="btn btn-sm btn-secondary" title="ویرایش"><i class="fas fa-user-edit"></i></a> 

                                        <form action="{{ route('user.status', $user->id) }}" method="post" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="status" value="{{ $user->status === 'active' ? 'inactive' : 'active' }}">
                                            <button type="submit" class="btn btn-sm {{ $user->status === 'active' ? 'btn-danger' : 'btn-success' }}">
                                                <i class="fas {{ $user->status === 'active' ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td> 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection