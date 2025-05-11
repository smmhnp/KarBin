@extends('base.BaseFormat')
@section('content')

    <div class="container">
        <h2><i class="fas fa-edit"></i>ایجاد / ویرایش وظیفه</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <form novalidate action="{{ route('editsubmit', ['id' => $data['task']->id]) }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="taskTitle" class="form-label">عنوان</label>
                    <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $data['task']->title) }}" id="taskTitle">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="taskDescription" class="form-label">شرح کامل</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="taskDescription" rows="5">{{ old('content', $data['task']->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 25px 35px;">

                    <div class="form-group">
                        <label for="project_name" class="form-label">پروژه مرتبط</label>
                        <input name="project_name" type="text" class="form-control @error('project_name') is-invalid @enderror" value="{{ old('project_name', $data['task']->project_name) }}" id="project_name">
                        @error('project_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="taskPriority" class="form-label">اولویت</label>
                        <select name="preference" class="form-control @error('preference') is-invalid @enderror" id="taskPriority">
                            <option>{{ old('preference', $data['task']->preference) }}</option>
                            <option>متوسط</option>
                            <option>بالا</option>
                            <option>پایین</option>
                        </select>
                        @error('preference')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="taskStatus" class="form-label">وضعیت</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" id="taskStatus">
                            <option>{{ old('status', $data['task']->status) }}</option>
                            <option>برای انجام</option>
                            <option>در حال انجام</option>
                            <option>بازبینی</option>
                            <option>انجام شده</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="taskDueDate" class="form-label">مهلت انجام</label>
                        <input name="deadline" type="date" class="form-control @error('deadline') is-invalid @enderror" id="taskDueDate" value="{{ old('deadline', $data['task']->deadline) }}">
                        @error('deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="taskAssignee" class="form-label">مسئول</label>
                        <select name="undertaking" class="form-control @error('undertaking') is-invalid @enderror" id="taskAssignee">
                            <option>{{ old('undertaking', $data['task']->undertaking) }}</option>
                            @foreach ($data['users'] as $user)
                                @if ($user->nickname == $data['task']->undertaking)
                                    @continue
                                @endif
                                <option>{{ $user->nickname }}</option>
                            @endforeach
                        </select>
                        @error('undertaking')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="attachment" class="form-label">پیوست فایل</label>
                    <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror" id="attachment">
                    @error('attachment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-5 d-flex gap-3">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> ذخیره وظیفه</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fas fa-times"></i> لغو</button>
                </div>
            </form>
        </div>
    </div>

@endsection