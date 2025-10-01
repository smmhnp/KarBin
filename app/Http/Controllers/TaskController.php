<?php

namespace App\Http\Controllers;

use App\Http\Requests\edieProjectRequest;
use App\Http\Requests\editRequest;
use App\Http\Requests\projectRequest;
use App\Http\Requests\taskRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use App\Models\Title;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;


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
        $tasks = Title::with('tasks')->get();

        return view('tasks.index', ['tasks' => $tasks]);

    }


    //................................................TaskBoard..........................

    public function board()
    {
        $tasks = Title::with('tasks')->get();

        return view('tasks.board', ['tasks' => $tasks]);
    }


    //................................................Project.List..........................

    public function list()
    {       
        $projects = Title::withCount([
            'tasks',
            'tasks as not_done_tasks_count' => function ($query) {
                $query->where('status', '!=', 'انجام شده');
            }
        ])->with('user')->get();

        return view('tasks.projects', ['projects' => $projects]);
    }


    //................................................showProject........................

    public function showProject($id) 
    {
        $tasks = Title::with('tasks')->find($id);

        return view('tasks.ShowProject', ['tasks' => $tasks]);

    }
    
    //................................................show...............................

    public function view($id)
    {

        $task = Task::find($id);
        $comment = Comment::with('user')->where('task_id', $task->id)->get();

        $data = [
           'task' => $task,
           'comment' => $comment
        ];

        return view('tasks.show', ['data' => $data]);
    }


    //................................................edit...............................

    public function edit($id)
    {
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

    public function editSubmit(editRequest $request, $id)
    {
        $task = Task::findOrFail($id);

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


    //................................................EditProject...............................

    public function EditProject($id)
    {
        $title = Title::with('user') -> findOrFail($id);
        $users = User::all();

        $data = [
           'title' => $title,
           'users' => $users 
        ];

        return view('tasks.EditProject', ['data' => $data]);
    }

    public function EditProjectSubmit(edieProjectRequest $request, $id)
    {
        $title = Title::findOrFail($id);
        
        $title->update([
            'title' => $request->input('title'),
            'user_id' => $request->input('undertaking'),
            'deadline' => $request->input('deadline'),
        ]);

        return redirect()->route('dashboard')->with('success', 'پروژه با موفقیت ویرایش شد');
    }

    //................................................add................................

    public function add()
    {
        $users = User::all();
        $titles = Title::all();
        
        return view('tasks.add', ['users' => $users, 'titles' => $titles]);
    }

    public function addsubmit(taskRequest $request)
    {
        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('private/tasks', 'local');
        }

        Task::create([
            'user_id' => Auth::id(),
            'title_id' => $request['title_id'],
            'project_name' => $request['project_name'],
            'content' => $request['content'],
            'undertaking' => $request['undertaking'],
            'preference' => $request['preference'],
            'deadline' => $request['deadline'],
            'status' => $request['status'],
            'attachment_path' => $attachmentPath,
        ]);

        return redirect()->route('dashboard')->with('success', 'تسک با موفقیت اضافه شد.');
    }

    
    //................................................AddProject................................

    public function AddProject()
    {
        $users = User::all();
        
        return view('tasks.AddProject', ['users' => $users]);
    }

    public function AddProjectSubmit(projectRequest $request)
    {
        Title::create([
            'title' => $request['title'],
            'user_id' => $request['undertaking'],
            'deadline' => $request['deadline'],
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
            return redirect()->route('task.view', ['id' => $id])->with('error', 'فایل پیوست وجود ندارد');
        }

        $filePath = $task->attachment_path;

        if (!Storage::disk('local')->exists($filePath)) {
            return redirect()->route('task.view', ['id' => $id])->with('error', 'فایل یافت نشد');
        }

        return Storage::download($filePath);
    }

    
    //................................................done...............................

    public function done(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->update([
            'status' => $request->input('status'),
        ]);
        
        return redirect()->route('dashboard')->with('success', 'تسک به عنوان انجام شده ذخیره شد');
    }
}