@extends('base.BaseFormat')
@section('content')

    <div class="container">
        <h2><i class="fas fa-edit"></i>ایجاد وظیفه</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                {{ $errors->first() }}
            </div>
        @endif
        
        <div class="card">
            <form novalidate action="{{ route('addsubmit') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="taskTitle" class="form-label">عنوان</label>
                    <select name="title_id" class="form-control" id="taskAssignee">
                        <option value=""></option>
                        @foreach ($titles as $title)
                            <option value="{{ $title['id'] }}" {{ old('title') == $title['title'] ? 'selected' : '' }}>
                                {{ $title['title'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="taskDescription" class="form-label">شرح کامل</label>
                    <textarea name="content" class="form-control" id="taskDescription" rows="5">{{ old('content') }}</textarea>
                </div>

                <div class="grid-container">
                <div class="form-group">
                    <label for="taskTitle" class="form-label">پروژه مرتبط</label>
                    <input name="project_name" type="text" class="form-control" id="taskTitle" value="{{ old('project_name') }}">
                </div>

                <div class="form-group">
                    <label for="taskPriority" class="form-label">اولویت</label>
                    <select name="preference" class="form-control" id="taskPriority">
                        <option value="متوسط" {{ old('preference') == 'متوسط' ? 'selected' : '' }}>متوسط</option>
                        <option value="بالا" {{ old('preference') == 'بالا' ? 'selected' : '' }}>بالا</option>
                        <option value="پایین" {{ old('preference') == 'پایین' ? 'selected' : '' }}>پایین</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="taskStatus" class="form-label">وضعیت</label>
                    <select name="status" class="form-control" id="taskStatus">
                        <option value="برای انجام" {{ old('status') == 'برای انجام' ? 'selected' : '' }}>برای انجام</option>
                        <option value="در حال انجام" {{ old('status') == 'در حال انجام' ? 'selected' : '' }}>در حال انجام</option>
                        <option value="بازبینی" {{ old('status') == 'بازبینی' ? 'selected' : '' }}>بازبینی</option>
                        <option value="انجام شده" {{ old('status') == 'انجام شده' ? 'selected' : '' }}>انجام شده</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="taskDueDate" class="form-label">مهلت انجام</label>
                    <input name="deadline" type="date" class="form-control" id="taskDueDate" value="{{ old('deadline') }}">
                </div>

                <div class="form-group">
                    <label for="taskAssignee" class="form-label">مسئول</label>
                    <select name="undertaking" class="form-control" id="taskAssignee">
                        <option value=""></option>
                        @foreach ($users as $user)
                            <option value="{{ $user['nickname'] }}" {{ old('undertaking') == $user['nickname'] ? 'selected' : '' }}>
                                {{ $user['nickname'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="attachment" class="form-label">پیوست</label>
                    <input type="file" name="attachment" class="form-control" id="attachment">
                </div>
                </div>

                <div class="mt-5 d-flex gap-3">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>ذخیره وظیفه</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fas fa-times"></i> لغو</button>
                </div>
            </form>
        </div>
    </div>

@endsection