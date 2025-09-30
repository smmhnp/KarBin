<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use App\Models\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class TaskController extends Controller
{
    //................................................dashboard..........................

    // public function dashboard()
    // {
    //     $response = Http::get('http://127.0.0.1:8000/api/task');

    //     if ($response->successful()) {
    //         $data = $response->json();

    //         return view('index', $data);
    //     } else {
    //         return response()->json(['message' => 'خطا در دریافت داده‌ها'], 500);
    //     }
    // }

    public function dashboard()
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }

        $tasks = Title::with('tasks')->get();

        return view('tasks.index', ['tasks' => $tasks]);

    }


    //................................................TaskBoard..........................

    public function board()
    {
        
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }
        
        $tasks = Title::with('tasks')->get();

        return view('tasks.board', ['tasks' => $tasks]);
    }


    //................................................Project.List..........................

    public function list()
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }
        
        $projects = Title::withCount([
            'tasks',
            'tasks as not_done_tasks_count' => function ($query) {
                $query->where('status', '!=', 'انجام شده');
            }
        ])->with('user')->get();

        return view('tasks.projects', ['projects' => $projects]);
    }


    //................................................showProject........................

    public function showProject($id) {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }

        $tasks = Title::with('tasks')->find($id);

        return view('tasks.ShowProject', ['tasks' => $tasks]);

    }
    
    //................................................show...............................

    public function view($id){

        $task = Task::find($id);
        $comment = Comment::with('user')->where('task_id', $task->id)->get();

        $data = [
           'task' => $task,
           'comment' => $comment
        ];

        return view('tasks.show', ['data' => $data]);
    }


    //................................................edit...............................

    public function edit($id){

        $task = Task::with('title')->findOrFail($id);
        $title = Title::all();
        $users = User::all();

        $data = [
           'task' => $task,
           'title' => $title,
           'users' => $users 
        ];

        return view('tasks.edit', ['data' => $data]);
    }

    public function editSubmit(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'title_id' => 'required',
                'project_name' => 'required|string|max:255',
                'content' => 'required|string',
                'undertaking' => 'required|string|max:255',
                'preference' => 'required|string|max:255',
                'deadline' => 'required|date',
                'status' => 'required|string|max:255',
                'attachment' => 'nullable|file|max:5120',
            ], [
                'title_id.required' => 'لطفاً عنوان تسک را وارد کنید.',
                'content.required' => 'لطفاً توضیحات تسک را وارد کنید.',
                'undertaking.required' => 'لطفاً مسئولیت را وارد کنید.',
                'preference.required' => 'لطفاً ترجیحات را وارد کنید.',
                'deadline.required' => 'لطفاً تاریخ انقضا را وارد کنید.',
                'deadline.date' => 'لطفاً تاریخ را به صورت صحیح وارد کنید.',
                'status.required' => 'لطفاً وضعیت تسک را وارد کنید.',
                'attachment.file' => 'فایل آپلودی باید یک فایل معتبر باشد.',
                'attachment.max' => 'حجم فایل نباید بیشتر از ۵ مگابایت باشد.',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $attachmentPath = $task->attachment_path;
            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                if ($attachmentPath && Storage::exists($attachmentPath)) {
                    Storage::delete($attachmentPath);
                }

                $attachmentPath = $request->file('attachment')->store('private/tasks', 'local');
            }

            $task->update([
                'title' => $request->input('title'),
                'project_name' => $request->input('project_name'),
                'content' => $request->input('content'),
                'undertaking' => $request->input('undertaking'),
                'preference' => $request->input('preference'),
                'deadline' => $request->input('deadline'),
                'status' => $request->input('status'),
                'attachment_path' => $attachmentPath,
            ]);

            return redirect()->route('dashboard')->with('success', 'تسک با موفقیت ویرایش شد');
        }

        return view('tasks.edit', compact('task'));
    }


    //................................................EditProject...............................

    public function EditProject($id){

        $title = Title::with('user') -> findOrFail($id);
        $users = User::all();

        $data = [
           'title' => $title,
           'users' => $users 
        ];

        return view('tasks.EditProject', ['data' => $data]);
    }

    public function EditProjectSubmit(Request $request, $id)
    {
        $title = Title::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'undertaking' => 'required',
            'deadline' => 'required|date',
        ], [
            'title.required' => 'لطفاً عنوان تسک را وارد کنید.',
            'title.max' => 'عنوان تسک نباید بیشتر از ۲۵۵ کاراکتر باشد.',
            'undertaking.required' => 'لطفاً مسئولیت را وارد کنید.',
            'deadline.required' => 'لطفاً تاریخ انقضا را وارد کنید.',
            'deadline.date' => 'لطفاً تاریخ را به صورت صحیح وارد کنید.',
        ]);
         
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $title->update([
            'title' => $request->input('title'),
            'user_id' => $request->input('undertaking'),
            'deadline' => $request->input('deadline'),
        ]);

        return redirect()->route('dashboard')->with('success', 'پروژه با موفقیت ویرایش شد');
    }

    //................................................add................................

    public function add(){

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }

        $users = User::all();
        $titles = Title::all();
        
        return view('tasks.add', ['users' => $users, 'titles' => $titles]);
    }

    public function addsubmit(Request $request)
    {
        $validated = $request->validate([
            'title_id' => 'required',
            'project_name' => 'required|string|max:255',
            'content' => 'required|string',
            'undertaking' => 'required|string|max:255',
            'preference' => 'required|string|max:255',
            'deadline' => 'required|date',
            'status' => 'required|string|max:255',
            'attachment' => 'nullable|file|max:5120',
        ], [
            'title_id.required' => 'لطفاً عنوان تسک را وارد کنید.',
            'content.required' => 'لطفاً توضیحات تسک را وارد کنید.',
            'undertaking.required' => 'لطفاً مسئولیت را وارد کنید.',
            'preference.required' => 'لطفاً ترجیحات را وارد کنید.',
            'deadline.required' => 'لطفاً تاریخ انقضا را وارد کنید.',
            'deadline.date' => 'لطفاً تاریخ را به صورت صحیح وارد کنید.',
            'status.required' => 'لطفاً وضعیت تسک را وارد کنید.',
            'attachment.file' => 'فایل آپلودی باید یک فایل معتبر باشد.',
            'attachment.max' => 'حجم فایل نباید بیشتر از ۵ مگابایت باشد.',
        ]);

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('private/tasks', 'local');
        }

        Task::create([
            'user_id' => Auth::id(),
            'title_id' => $validated['title_id'],
            'project_name' => $validated['project_name'],
            'content' => $validated['content'],
            'undertaking' => $validated['undertaking'],
            'preference' => $validated['preference'],
            'deadline' => $validated['deadline'],
            'status' => $validated['status'],
            'attachment_path' => $attachmentPath,
        ]);

        return redirect()->route('dashboard')->with('success', 'تسک با موفقیت اضافه شد.');
    }

    
    //................................................AddProject................................

    public function AddProject(){

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }

        $users = User::all();
        
        return view('tasks.AddProject', ['users' => $users]);
    }

    public function AddProjectSubmit(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'undertaking' => 'required',
            'deadline' => 'required|date',
        ], [
            'title.required' => 'لطفاً عنوان تسک را وارد کنید.',
            'title.max' => 'عنوان تسک نباید بیشتر از ۲۵۵ کاراکتر باشد.',
            'undertaking.required' => 'لطفاً مسئولیت را وارد کنید.',
            'deadline.required' => 'لطفاً تاریخ انقضا را وارد کنید.',
            'deadline.date' => 'لطفاً تاریخ را به صورت صحیح وارد کنید.',
        ]);

        Title::create([
            'title' => $validated['title'],
            'user_id' => $validated['undertaking'],
            'deadline' => $validated['deadline'],
        ]);

        return redirect()->route('dashboard')->with('success', 'تسک با موفقیت اضافه شد.');
    }

    //................................................delete.............................

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);

            if ($task->attachment_path && Storage::exists($task->attachment_path)) {
                Storage::delete($task->attachment_path);
            }

            $task->delete();

            return redirect()->route('tasks.index')->with('success', 'تسک با موفقیت حذف شد.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('dashboard')->with('error', 'تسک مورد نظر پیدا نشد.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'خطا در حذف تسک: ' . $e->getMessage());
        }
    }


    //................................................download...........................

     public function webdownload($id)
    {
        $task = Task::findOrFail($id);

        if (!$task->attachment_path) {
            return response()->json(['message' => 'فایل پیوست وجود ندارد'], Response::HTTP_NOT_FOUND);
        }

        $filePath = $task->attachment_path;

        if (!Storage::disk('local')->exists($filePath)) {
            return response()->json(['message' => 'فایل یافت نشد'], Response::HTTP_NOT_FOUND);
        }

        return Storage::download($filePath);
    }

    
    //................................................done...............................

    public function done(Request $request, $id){
        $task = Task::findOrFail($id);

        $task->update([
            'status' => $request->input('status'),
        ]);
        
        return redirect()->route('dashboard')->with('success', 'تسک به عنوان انجام شده ذخیره شد');
    }
}