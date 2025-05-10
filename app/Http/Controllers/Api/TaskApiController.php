<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class TaskApiController extends ApiController
{
    public function index()
    {
        return $this->ResponseSuccess(Task::all(), 200);
    }


    //................................................show...............................

    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->ResponseError('تسک پیدا نشد', 404);
        }

        $user = User::find($task->user_id);
        if (!$user) {
            return $this->ResponseError('کاربر مربوط به این تسک پیدا نشد', 404);
        }

        $data = [
            'task' => $task,
            'user' => $user
        ];

        return $this->ResponseSuccess($data, 200);
    }


    //................................................edit...............................

    public function editSubmit(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return $this->ResponseError('تسک پیدا نشد', 404);
        }

        // بررسی مجوز کاربر (در صورت نیاز)
        // if ($task->user_id != Auth::id()) {
        //     return $this->ResponseError('شما مجاز به ویرایش این تسک نیستید', 403);
        // }

        $validator = Validator::make($request->all(), [
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
            return $this->ResponseError($validator->errors(), 422);
        }

        $task->update($request->only([
            'title', 'project_name', 'content', 'undertaking', 'preference', 'deadline', 'status'
        ]));

        return $this->ResponseSuccess(['message' => 'تسک با موفقیت ویرایش شد', 'task' => $task], 200);
    }


    //................................................add................................

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'project_name' => 'required|string|max:255',
            'content' => 'required|string',
            'undertaking' => 'required|string|max:255',
            'preference' => 'required|string|max:255',
            'deadline' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->ResponseError($validator->errors(), 422);
        }

        $task = Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'project_name' => $request->project_name,
            'content' => $request->content,
            'undertaking' => $request->undertaking,
            'preference' => $request->preference,
            'deadline' => $request->deadline,
            'status' => $request->status,
        ]);

        return $this->ResponseSuccess(['message' => 'تسک با موفقیت ایجاد شد', 'task' => $task], 201);
    }


}
