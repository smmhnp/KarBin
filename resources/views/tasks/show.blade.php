@extends('base.BaseFormat')
@section('content')

    <div class="container">

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

        <h2><i class="fas fa-clipboard-list"></i>جزئیات وظیفه</h2>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title" style="margin-bottom: 0;">{{ $data['task'] -> title -> title }}</h3>
                <span class="badge badge-status-{{ color_status_style ($data['task'] -> status) }}">{{ $data['task'] -> status }}</span>
            </div>

        <div style="margin-bottom: 40px; padding-top: 25px; display: grid; grid-template-columns: 1fr;">
            <div> 
                <h4><i class="fas fa-info-circle"></i> شرح وظیفه</h4> 
                <p>{{ $data['task']->content }}</p> 
            </div>
        </div>

        <div style="display: flex; gap: 35px; overflow-x: auto; justify-content: space-between;">
            <div style="min-width: 200px;">
                <h4><i class="fas fa-flag"></i> اولویت</h4> 
                <p>
                    <span class="badge badge-priority-{{ color_preference_style($data['task']->preference) }}">
                        {{ $data['task']->preference }}
                    </span>
                </p> 
            </div>
            <div style="min-width: 200px;">
                <h4><i class="fas fa-user-tie"></i> مسئول</h4> 
                <p>{{ $data['task']->undertaking }}</p> 
            </div>
            <div style="min-width: 200px;">
                <h4><i class="far fa-calendar-alt"></i> مهلت</h4> 
                <p>{{ $data['task']->deadline->toDateString() }}</p> 
            </div>
            <div style="min-width: 200px;">
                <h4><i class="fas fa-project-diagram"></i> پروژه</h4> 
                <p>{{ $data['task']->project_name }}</p> 
            </div>
            <div style="min-width: 200px;">
                <h4><i class="far fa-clock"></i> زمان ثبت</h4> 
                <p>{{ $data['task']->created_at->toDateString() }}</p> 
            </div>
        </div>

        <!-- download attachment -->
        <a href="{{ route('file.download', ['id' => $data['task']->id]) }}" class="btn btn-success">دانلود فایل پیوست</a>

        <!-- comments -->
        <div class="comments-section">
            @if(count($data['comment']) != 0)
                <h4><i class="fas fa-comments"></i> بحث و گفتگو ({{ count($data['comment']) }})</h4>
            @else
                <h4><i class="fas fa-comments"></i> هیچ نظری برای این وظیفه ثبت نشده است</h4>
            @endif

            @foreach($data['comment'] as $comment)
                <div class="comment">
                    <div class="comment-avatar" style="background-color: var(--success-color);">{{ Str::substr($comment -> user -> nickname, 0, 3) }}</div>
                    <div class="comment-body">
                        <div class="comment-meta"><span class="comment-author">{{ $comment -> user -> nickname }}</span> <span class="comment-date">{{ jDate($comment->created_at)->ago() }}</span></div>
                        <p class="comment-text">{{ $comment -> body }}</p>
                    </div>
                </div>
            @endforeach

            <form action="{{ route('comment',  ['task' => $data['task']->id]) }}" method="post" class="comment-form mt-4">
                @csrf
                <div class="form-group mb-2">
                    <label for="newComment" class="form-label">افزودن نظر جدید:</label>
                    <textarea name="body" class="form-control" id="newComment" rows="3" placeholder="نظر یا سوال خود را بنویسید..."></textarea>
                </div>
                <button type="submit" class="btn btn-info btn-sm"><i class="fas fa-paper-plane"></i>ارسال</button>
            </form>
        </div>

        <!-- task modify -->
        <div class="mt-5 d-flex gap-3" style="border-top: 1px solid var(--border-color-light); padding-top: 30px;">

            @if (Auth::user() -> role == 'super_admin' or Auth::user() -> role == 'admin')
                <a href="{{ route('edit', ['id' => $data['task'] ->id]) }}" class="btn btn-secondary"><i class="fas fa-edit"></i>ویرایش</a>

                <form action="{{ route('tasks.destroy', ['id' => $data['task'] -> id]) }}" method="POST" onsubmit="return confirm('آیا از حذف این تسک مطمئنی؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" title="حذف">
                        <i class="fas fa-trash-alt"></i> حذف
                    </button>
                </form>


            @elseif (Auth::user() -> role == 'developer')
                <a href="{{ route('edit', ['id' => $data['task'] ->id]) }}" class="btn btn-secondary"><i class="fas fa-edit"></i>ویرایش</a>
            @endif

            @if($data['task']->status != 'انجام شده')
                <form action="{{ route('done', ['id' => $data['task'] -> id]) }}" method="post">
                    @csrf
                    <input type="hidden" name="status" value="انجام شده">
                    <button class="btn btn-success"><i class="fas fa-check-circle"></i>علامت زدن به عنوان انجام شده</button>
                </form>
            @endif
            <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fas fa-times"></i> بازگشت</button>
        </div>
    </div>
          
@endsection