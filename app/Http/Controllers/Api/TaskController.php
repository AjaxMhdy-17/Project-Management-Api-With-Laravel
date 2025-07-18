<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TaskRequest;
use App\Http\Requests\Api\TaskUpdateRequest;
use App\Http\Resources\Api\TaskCollection;
use App\Http\Resources\Api\TaskResources;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('project')->latest();
        if (request('is_done')) {
            $tasks->where('is_done', 1);
        }
        return new TaskCollection($tasks->paginate(8));
    }

    public function show(Request $request, Task $task)
    {
        $task->load('project');
        return new TaskResources($task);
    }

    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        $task = Auth::user()->tasks()->create($data);
        return new TaskResources($task);
    }


    public function update(TaskUpdateRequest $request, Task $task)
    {

        $data = $request->validated();
        if ($request->user()->id != $task->user_id) {
            return response()->json([
                'msg' => "User Not Authorised!",
            ]);
        }
        $task->update($data);
        return new TaskResources($task);
    }

    public function destroy(Request $request, Task $task)
    {

        if ($request->user()->id != $task->user_id) {
            return response()->json([
                'msg' => "User Not Authorised!",
            ]);
        }
        $task->delete();
        return response()->json([
            "msg" => "Task Deleted Successfully!"
        ]);
    }
}
