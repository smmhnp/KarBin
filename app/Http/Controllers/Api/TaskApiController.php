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
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;



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
        

        $validator = Validator::make($request->all(), [
            'title_id' => 'required|string|max:255',
            'project_name' => 'required|string|max:255',
            'content' => 'required|string',
            'undertaking' => 'required|string|max:255',
            'preference' => 'required|string|max:255',
            'deadline' => 'required|date',
            'status' => 'required|string|max:255',
            'attachment' => 'nullable|file|max:5120',
        ], [
            'required' => 'فیلد :attribute الزامی است',
            'max' => 'فیلد :attribute نباید بیشتر از :max کاراکتر باشد',
            'date' => 'فیلد :attribute باید یک تاریخ معتبر باشد',
            'attachment.file' => 'فایل پیوست باید یک فایل معتبر باشد',
            'attachment.max' => 'حجم فایل پیوست نباید بیشتر از ۵ مگابایت باشد',
        ]);

        if ($validator->fails()) {
            return $this->ResponseError($validator->errors(), 422);
        }

        $attachmentPath = $task->attachment_path;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            if ($file->isValid()) {
                if ($attachmentPath && Storage::exists($attachmentPath)) {
                    Storage::delete($attachmentPath);
                }
                $attachmentPath = $file->store('private/tasks', 'local');
            } else {
                return $this->ResponseError('فایل پیوست معتبر نیست', 400);
            }
        }

        $task->update($request->only([
            'title', 'project_name', 'content', 'undertaking', 'preference', 'deadline', 'status'
        ]) + ['attachment_path' => $attachmentPath]);

        return $this->ResponseSuccess(['message' => 'تسک با موفقیت ویرایش شد', 'task' => $task], 200);
    }


    //................................................add................................

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_id' => 'required|string|max:255',
            'project_name' => 'required|string|max:255',
            'content' => 'required|string',
            'undertaking' => 'required|string|max:255',
            'preference' => 'required|string|max:255',
            'deadline' => 'required|date',
            'status' => 'required|string|max:255',
            'attachment' => 'nullable|file|max:5120',
        ]);

        if ($validator->fails()) {
            return $this->ResponseError($validator->errors(), 422);
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            if ($file->isValid()) {
                $attachmentPath = $file->store('private/tasks', 'local');
            } else {
                return $this->ResponseError('File is invalid or not uploaded', 400);
            }
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
            'attachment_path' => $attachmentPath,
        ]);

        return $this->ResponseSuccess(['message' => 'Task successfully created', 'task' => $task], 201);
    }


    //................................................download...........................

    public function download($id)
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
