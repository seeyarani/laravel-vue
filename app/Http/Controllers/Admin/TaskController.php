<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::with('user','project')->get();

        return response()->json($tasks,200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $task = Task::create([
            'title'  => $request->title,
            'description' => $request->description,
            'user_id'  => $request->user_id,
            'project_id' => $request->project_id,
            'deadline_priority'  => $request->priority,
            'due_on' => $request->due_date,
        ]);

        return response()->json(['message' => 'Project created Successfully'], 200);
    }

    public function edit(Request $request)
    {
        $task = Task::where('id', $request->taskId)->first();

        return response()->json($task, 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $task = Task::where('id', $request->taskId)->update([
            'title'  => $request->title,
            'description' => $request->description,
            'user_id'  => $request->user_id,
            'project_id' => $request->project_id,
            'deadline_priority'  => $request->priority,
            'due_on' => $request->due_date,
        ]);

        return response()->json($task, 200);
    }

    public function delete(Request $request)
    {
        $task = Task::where('id', $request->taskId)->delete();

        return response()->json(['message' => 'Task deleted Successfully'], 200);
    }
}
