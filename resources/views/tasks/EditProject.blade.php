@extends('base.BaseFormat')
@section('content')

    <div class="container">
        <h2><i class="fas fa-edit"></i>ایجاد پروژه</h2>
        <div class="card">

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif
            <form novalidate action="{{ route('EditProjectSubmit', ['id' => $data['title'] -> id]) }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="taskTitle" class="form-label">عنوان</label>
                    <input name="title" type="text" class="form-control" id="taskTitle" value="{{ old('title', $data['title'] -> title) }}">
                </div>

                <div class="form-group">
                    <label for="taskDueDate" class="form-label">مهلت انجام</label>
                    <input name="deadline" type="date" class="form-control" id="taskDueDate" value="{{ old('deadline', $data['title'] -> deadline) }}">
                </div>

                <div class="form-group">
                    <label for="taskAssignee" class="form-label">مسئول</label>
                    <select name="undertaking" class="form-control" id="taskAssignee">
                        <option value="{{ $data['title'] -> user -> id }}">{{ $data['title'] -> user -> nickname }}</option>
                        @foreach ($data['users'] as $user)
                            @if ($user['nickname'] === $data['title'] -> user -> nickname)
                                @continue
                            @endif
                            <option value="{{ $user['id'] }}" {{ old('undertaking') == $user['nickname'] ? 'selected' : '' }}>
                                {{ $user['nickname'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-5 d-flex gap-3">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>ذخیره وظیفه</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fas fa-times"></i> لغو</button>
                </div>
            </form>
        </div>
    </div>

@endsection