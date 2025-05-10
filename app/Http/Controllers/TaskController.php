<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;


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
        $user = User::find($task -> user_id);

        // if ($task->user_id != Auth::user()->id) {
        //     return redirect()->route('dashboard')->with('error', 'شما دسترسی به این تسک را ندارید');
        // }

        $data = [
           'task' => $task,
           'user' => $user 
        ];

        return view('tasks.edit', ['data' => $data]);
    }

    public function editSubmit($id)
    {
        $task = Task::findOrFail($id);
        
        // if ($task->user_id != Auth::user()->id()) {
        //     return redirect()->route('tasks.index')->with('error', 'شما دسترسی به این تسک را ندارید');
        // }
    
        if (request()->isMethod('POST')) {
            $validator = Validator::make(request()->all(), [
                'title' => 'required|string|max:255',
                'project_name' => 'required|string|max:255',
                'content' => 'required|string',
                'undertaking' => 'required|string|max:255',
                'preference' => 'required|string|max:255',
                'deadline' => 'required|date',
                'status' => 'required|string|max:255',
            ], [
                'required' => 'فیلد :attribute الزامی است',
                'max' => 'فیلد :attribute نباید بیشتر از :max کاراکتر باشد',
                'date' => 'فیلد :attribute باید یک تاریخ معتبر باشد'
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $updated = $task->update([
                'title' => request('title'),
                'project_name' => request('project_name'),
                'content' => request('content'),
                'undertaking' => request('undertaking'),
                'preference' => request('preference'),
                'deadline' => request('deadline'),
                'status' => request('status'),
            ]);
    
            if ($updated) {
                return redirect()->route('dashboard')->with('success', 'تسک با موفقیت ویرایش شد');
            }
    
            return back()->with('error', 'خطا در ویرایش تسک');
        }
    
        return view('tasks.edit', compact('task'));
    }


    //................................................add................................

    public function add(){
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید');
        }

        return view('tasks.add');
    }

    public function addsubmit(Request $request){

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'project_name' => 'required|string|max:255',
            'content' => 'required|string',
            'undertaking' => 'required|string|max:255',
            'preference' => 'required|string|max:255',
            'deadline' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $user = Task::create([
            'user_id' => Auth::user()->id,
            'title' => $validated['title'],
            'project_name' => $validated['project_name'],
            'content' => $validated['content'],
            'undertaking' => $validated['undertaking'],
            'preference' => $validated['preference'],
            'deadline' => $validated['deadline'],
            'status' => ($validated['status']),
        ]);

        return redirect()->route('dashboard')->with('success', ',ورود با موفقیت انجام شد');
    }


    //................................................delete.............................

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);

            if ($task->user_id != Auth::id()) {
                return redirect()->route('tasks.index')->with('error', 'شما مجاز به حذف این تسک نیستید.');
            }

            $task->delete();

            return redirect()->route('tasks.index')->with('success', 'تسک با موفقیت حذف شد.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('dashboard')->with('error', 'تسک مورد نظر پیدا نشد.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'خطا در حذف تسک: ' . $e->getMessage());
        }
    }
}