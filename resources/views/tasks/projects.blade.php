@extends('base.BaseFormat')
@section('content')

    <div class="container">
        <h2><i class="fas fa-folder-open"></i>مدیریت پروژه‌ها</h2>
        <div class="card">
            <div class="section-header">
                <h3 style="margin-bottom: 0;">لیست پروژه‌ها</h3>
               @if (Auth::user()->role == 'admin' or Auth::user()->role == 'devloper')
                    <a href="<?php //echo URLROOT; ?>tasks/add" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>پروژه جدید</a>
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
                            <th>عملیات</th> 
                        </tr> 
                    </thead>
                    <tbody>
                       @foreach ($projects as $project)
                            <tr> 
                                <td>
                                    <strong>{{ $project -> title }}</strong>
                                </td> 
                                <td>3 / 4</td> 
                                <td>{{ $project -> undertaking }}</td> 
                                <td>{{ $project -> deadline }}</td> 
                                <td>
                                    <div class="button-group">
                                        <a href="{{ route('task.view', ['id' => $project->id]) }}" class="btn btn-sm btn-secondary" title="نمایش"><i class="fas fa-eye"></i></a> 
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