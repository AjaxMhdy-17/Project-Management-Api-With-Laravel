<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\TaskRequest;
use App\Http\Requests\Api\TaskUpdateRequest;
use App\Http\Resources\Api\TaskCollection;
use App\Http\Resources\Api\TaskResources;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // Task::query()->delete();

        $tasks = Task::latest();
        if (request('is_done')) {
            $tasks->where('is_done', 1);
        }
        return new TaskCollection($tasks->paginate(8));
    }

    public function show(Request $request, Task $task)
    {
        return new TaskResources($task);
    }

    public function store(TaskRequest $request)
    {

        $data = $request->validated();
        $task = Task::create($data);
        return new TaskResources($task);
    }


    public function update(TaskUpdateRequest $request, Task $task)
    {

        $data = $request->validated();
        $task->update($data);
        return new TaskResources($task);
    }

    public function destroy(Request $request, Task $task)
    {
        $task->delete();
        return response()->json($task);
    }
}
