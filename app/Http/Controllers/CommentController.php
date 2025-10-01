<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __invoke(Request $request, Task $task)
    {
        $request->validate(['body' => 'required']);

        $task->comments()->create([
            'body' => $request->body,
            'user_id' => Auth::user() -> id,
        ]);

        return back();
    }
}
