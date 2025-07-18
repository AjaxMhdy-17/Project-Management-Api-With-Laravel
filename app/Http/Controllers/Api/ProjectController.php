<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProjectCollection;
use App\Http\Resources\Api\ProjectResources;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function index()
    {
        return new ProjectCollection(Project::latest()->get());
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        // return response()->json($request->user());
        $project = $request->user()->projects()->create($data);
        return response()->json($project);
    }

    public function show(string $id)
    {
        $project = Project::findOrFail($id);
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
            'title' => 'required|string'
        ]);
    }
}
