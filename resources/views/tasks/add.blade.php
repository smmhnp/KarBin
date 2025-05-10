@extends('base.BaseFormat')
@section('content')

    <div class="container">
        <h2><i class="fas fa-edit"></i>ایجاد / ویرایش وظیفه</h2>
        <div class="card">
            <form novalidate action="{{ route('addsubmit') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="taskTitle" class="form-label">عنوان</label>
                    <input name="title" type="text" class="form-control" id="taskTitle">
                </div>

                <div class="form-group">
                    <label for="taskDescription" class="form-label">شرح کامل</label>
                    <textarea name="content" class="form-control" id="taskDescription" rows="5"></textarea>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 25px 35px;">

                    <div class="form-group">
                        <label for="taskTitle" class="form-label">پروژه مرتبط</label>
                        <input name="project_name" type="text" class="form-control" id="taskTitle">
                    </div>

                    <div class="form-group">
                        <label for="taskPriority" class="form-label">اولویت</label>
                        <select name="preference" class="form-control" id="taskPriority">
                            <option>متوسط</option>
                            <option>بالا</option>
                            <option>پایین</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="taskStatus" class="form-label">وضعیت</label>
                        <select name="status" class="form-control" id="taskStatus">
                            <option>برای انجام</option>
                            <option>در حال انجام</option>
                            <option>بازبینی</option>
                            <option>انجام شده</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="taskDueDate" class="form-label">مهلت انجام</label>
                        <input name="deadline" type="date" class="form-control" id="taskDueDate">
                    </div>

                    <div class="form-group"><label for="taskAssignee" class="form-label">مسئول</label>
                        <select name="undertaking" class="form-control" id="taskAssignee">
                            <?php //foreach ($data['users'] as $user): ?>
                                <option><?php //echo $user -> nickname; ?></option>
                                <option>ali</option>
                            <?php //endforeach; ?>
                        </select>
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