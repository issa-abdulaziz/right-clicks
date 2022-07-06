<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::with('users:id,name')->get();
        $users = User::where('is_admin', false)->get(['id', 'name']);
        return view('task.index', compact('tasks', 'users'));
    }

    public function store(TaskRequest $request)
    {
        DB::transaction(function () use ($request) {
            $task = Task::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
            ]);
            $task->users()->sync($request->users);
        });
        return redirect()->route('task.index')->with('success', 'Task Added Successfully');
    }

    public function update(TaskRequest $request, Task $task)
    {
        DB::transaction(function () use ($request, $task) {
            $task->update([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
            ]);
            $task->users()->sync($request->users);
        });
        return redirect()->route('task.index')->with('success', 'Task Updated Successfully');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('task.index')->with('success', 'Task Deleted Successfully');
    }
}
