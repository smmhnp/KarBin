<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;
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
        
        $tasks = Task::all();
        $user = Auth::user();

        return view('tasks.index', ['data' => $tasks, 'user' => $user]);
    }


    //................................................TaskBoard..........................

    public function board()
    {
        
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }
        
        $tasks = Task::all();

        return view('tasks.board', ['tasks' => $tasks]);
    }


    //................................................Project.List..........................

    public function list()
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }
        
        $projects = Task::all();

        return view('tasks.projects', ['projects' => $projects]);
    }

    
    //................................................show...............................

    public function view($id){

        $task = Task::find($id);
        $user = User::find($task -> user_id);

        $data = [
           'task' => $task,
           'user' => $user 
        ];

        return view('tasks.show', ['data' => $data]);
    }


    //................................................edit...............................

    public function edit($id){

        $task = Task::find($id);
        $users = User::all();

        $data = [
           'task' => $task,
           'users' => $users 
        ];

        return view('tasks.edit', ['data' => $data]);
    }

    public function editSubmit(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // if ($task->user_id !== Auth::id()) {
        //     return redirect()->route('tasks.index')->with('error', 'شما دسترسی به این تسک را ندارید.');
        // }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'project_name' => 'required|string|max:255',
                'content' => 'required|string',
                'undertaking' => 'required|string|max:255',
                'preference' => 'required|string|max:255',
                'deadline' => 'required|date',
                'status' => 'required|string|max:255',
                'attachment' => 'nullable|file|max:5120',
            ], [
                'title.required' => 'لطفاً عنوان تسک را وارد کنید.',
                'title.max' => 'عنوان تسک نباید بیشتر از ۲۵۵ کاراکتر باشد.',
                'project_name.required' => 'لطفاً نام پروژه را وارد کنید.',
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


    //................................................add................................

    public function add(){

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }

        $users = User::all();
        
        return view('tasks.add', ['users' => $users]);
    }

    public function addsubmit(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'project_name' => 'required|string|max:255',
            'content' => 'required|string',
            'undertaking' => 'required|string|max:255',
            'preference' => 'required|string|max:255',
            'deadline' => 'required|date',
            'status' => 'required|string|max:255',
            'attachment' => 'nullable|file|max:5120',
        ], [
            'title.required' => 'لطفاً عنوان تسک را وارد کنید.',
            'title.max' => 'عنوان تسک نباید بیشتر از ۲۵۵ کاراکتر باشد.',
            'project_name.required' => 'لطفاً نام پروژه را وارد کنید.',
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
            'title' => $validated['title'],
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

}