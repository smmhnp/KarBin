@extends('base.BaseFormat')
@section('content')

    <div class="container">
        <h2><i class="fas fa-folder-open"></i>مدیریت پروژه‌ها</h2>
        <div class="card">
            <div class="section-header">
                <h3 style="margin-bottom: 0;">لیست پروژه‌ها</h3>
               @if (Auth::user()->role == 'super_admin')
                    <a href="{{ route('AddProject') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>پروژه جدید</a>
                @endif
            </div>
            <div class="table-container">
                <table class="table">
                    <thead> 
                        <tr> 
                            <th>نام پروژه</th> 
                            <th>تعداد وظایف (فعال / کل)</th> 
                            <th>مدیر پروژه (نام مستعار)</th> 
                            <th>تاریخ ایجاد</th> 
                            <th>مهلت انجام</th> 
                            <th>عملیات</th> 
                        </tr> 
                    </thead>
                    <tbody>
                        @foreach ($projects as $item)
                            <tr> 
                                <td>{{ $item -> title }}</td> 
                                <td>{{ $item -> not_done_tasks_count }} / {{ $item -> tasks->count() }}</td> 
                                <td>{{ $item -> user -> nickname }}</td> 
                                <td>{{ jDate($item -> created_at) -> ago() }}</td> 
                                <td>{{ jDate($item -> deadline) -> ago() }}</td> 
                                <td>
                                    <a href="{{ route('showProject', ['id' => $item -> id]) }}" class="btn btn-sm btn-secondary" title="نمایش">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('EditProject', ['id' => $item -> id]) }}" class="btn btn-sm btn-secondary" title="ویرایش">
                                        <i class="fas fa-edit"></i>
                                    </a> 
                                </td>
                            </tr> 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection 