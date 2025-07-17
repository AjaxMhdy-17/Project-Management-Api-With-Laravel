<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sclass;
use Illuminate\Http\Request;

class SclassController extends Controller
{

    public function index()
    {
        $classes = Sclass::latest()->get();
        return response()->json($classes);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $class = Sclass::create($data);
        return response()->json([
            'message' => 'success',
            'data' => $class
        ]);
    }

    public function show(string $id)
    {
        $class = Sclass::findOrFail($id);
        return response()->json([
            'message' => 'success',
            'id' => $id,
            'data' => $class
        ]);
    }

    public function edit(string $id)
    {
        $class = Sclass::findOrFail($id);
        return response()->json([
            'message' => "edit",
            'data' => $class
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'class_name' => 'required|unique:sclasses,class_name'
        ]);

        $class = Sclass::findOrFail($id);
        $uclass = $class->update($data);

        return response()->json([
            'message' => "updated",
            'data' => $uclass
        ]);
    }

    public function destroy(string $id)
    {
        $class = Sclass::findOrFail($id);
        $sclass = $class->delete();
        return response()->json([
            'message' => "updated",
            'data' => $sclass
        ]);
    }


    public function validateData($request)
    {
        return $request->validate([
            'class_name' => 'required|string|unique:sclasses,class_name'
        ]);
    }
}
