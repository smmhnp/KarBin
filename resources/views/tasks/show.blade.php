@extends('base.BaseFormat')
@section('content')

    <div class="container">
        <h2><i class="fas fa-clipboard-list"></i>جزئیات وظیفه</h2>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title" style="margin-bottom: 0;">{{ $data['task'] -> title }}</h3>
                <span class="badge badge-status-{{ color_status_style ($data['task'] -> status) }}">{{ $data['task'] -> status }}</span>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px 35px; margin-bottom: 40px; padding-top: 25px;">
                <div> 
                    <h4><i class="fas fa-info-circle"></i> شرح وظیفه</h4> 
                    <p>
                    {{ $data['task'] -> content }}
                    </p> 
                </div>
                <div> 
                    <h4><i class="fas fa-flag"></i> اولویت</h4> 
                    <p>
                        <span class="badge badge-priority-{{ color_preference_style ($data['task'] -> preference) }}">{{ $data['task'] -> preference }}</span>
                    </p> 
                </div>
                <div> 
                    <h4><i class="fas fa-user-tie"></i> مسئول</h4> 
                    <p>{{ $data['task'] -> undertaking }}</p> 
                </div>
                <div> 
                    <h4><i class="far fa-calendar-alt"></i> مهلت</h4> 
                    <p>{{ $data['task'] -> deadline -> toDateString() }}</p> 
                </div>
                <div> 
                    <h4><i class="fas fa-project-diagram"></i> پروژه</h4> 
                    <p>{{ $data['task'] -> project_name }}</p> 
                </div>
                <div> 
                    <h4><i class="far fa-clock"></i> زمان ثبت</h4> 
                    <p>{{ $data['task'] -> created_at -> toDateString() }}</p> 
                </div>                
            </div>
            
            <a href="{{ route('file.download', ['id' => $data['task']->id]) }}" class="btn btn-success">دانلود فایل</a>

            <div class="comments-section">
                <h4><i class="fas fa-comments"></i>بحث و گفتگو (1)</h4>
                <div class="comment">
                    <div class="comment-avatar" style="background-color: var(--success-color);">Nass</div>
                    <div class="comment-body">
                        <div class="comment-meta"><span class="comment-author">Nass</span> <span class="comment-date">چند دقیقه پیش</span></div>
                        <p class="comment-text">سلام، لینک طرح‌های اولیه در Figma آپدیت شد. لطفاً بررسی بفرمایید و بازخوردتون رو اعلام کنید.</p>
                    </div>
                </div>
                <form class="comment-form mt-4">
                    <div class="form-group mb-2">
                        <label for="newComment" class="form-label">افزودن نظر جدید:</label>
                        <textarea class="form-control" id="newComment" rows="3" placeholder="نظر یا سوال خود را بنویسید..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-info btn-sm"><i class="fas fa-paper-plane"></i>ارسال</button>
                </form>
            </div>

            <div class="mt-5 d-flex gap-3" style="border-top: 1px solid var(--border-color-light); padding-top: 30px;">

                @if (Auth::user() -> role == 'admin')
                    <a href="{{ route('edit', ['id' => $data['task'] ->id]) }}" class="btn btn-secondary"><i class="fas fa-edit"></i>ویرایش</a>

                    <form action="{{ route('tasks.destroy', ['id' => $data['task'] ->id]) }}" method="POST" onsubmit="return confirm('آیا از حذف این تسک مطمئنی؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" title="حذف">
                            <i class="fas fa-trash-alt"></i> حذف
                        </button>
                    </form>


                @elseif (Auth::user() -> role == 'developer')
                    <a href="{{ route('edit', ['id' => $data['task'] ->id]) }}" class="btn btn-secondary"><i class="fas fa-edit"></i>ویرایش</a>
                @endif

                <button class="btn btn-success"><i class="fas fa-check-circle"></i>علامت زدن به عنوان انجام شده</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fas fa-times"></i> لغو</button>
            </div>
        </div>
    </div>
          
@endsection