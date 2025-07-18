<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProjectCollection;
use App\Http\Resources\Api\ProjectResources;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {

        $projects = Project::with('tasks')->get();
        return new ProjectCollection($projects);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $user_ids = json_decode($data['member_id'], true);
        $project = $request->user()->projects()->create($data);

        for ($i = 0; $i < count($user_ids); $i++) {
            $project->members()->attach($user_ids[$i]);
        }
        return response()->json($project);
    }

    public function show(string $id)
    {
        $project = Project::with(['tasks', 'members'])->findOrFail($id);
        return new ProjectResources($project);
    }


    public function update(Request $request, Project $project)
    {
        $data = $this->validateData($request);
        if ($request->user()->id != $project->user_id) {
            return response()->json([
                'msg' => "Something Went Wrong!"
            ]);
        }
        $pro = Project::findOrFail($project->id);
        $pro->update($data);
        $user_ids = json_decode($data['member_id'], true);
        $pro->members()->sync($user_ids);
        return response()->json([
            'msg' => "Project Updated!"
        ]);
    }


    public function destroy(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        if ($request->user()->id != $project->user_id) {
            return response()->json([
                'msg' => "Something Went Wrong!"
            ]);
        }
        $project->delete();
        return response()->json([
            'msg' => "Project Deleted!"
        ]);
    }

    public function validateData($request)
    {
        return $request->validate([
            'title' => 'required|string',
            'member_id' => 'sometimes'
        ]);
    }
}
