<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::all();

        return response()->json($projects,200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $project = Project::create([
            'name' => $request->project_name,
            'client_name' => $request->client_name,
        ]);

        return response()->json(['message' => 'Project created Successfully'], 200);
    }

    public function edit(Request $request)
    {
        $project = Project::where('id', $request->projectId)->first();

        return response()->json($project, 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $project = Project::where('id', $request->projectId)->update([
            'name'  => $request->project_name,
            'client_name' => $request->client_name,
        ]);

        return response()->json($project, 200);
    }

    public function delete(Request $request)
    {
        $project = Project::where('id', $request->projectId)->delete();

        return response()->json(['message' => 'Project deleted Successfully'], 200);
    }
}
