<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
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
        $is_admin = auth()->user()->is_admin;
        $tasks = $is_admin ? Task::with('users:id,name')->orderBy('status_updated_at', 'desc')->get() : auth()->user()->tasks()->with('users:id,name')->orderBy('status_updated_at', 'desc')->get();
        $users = $is_admin ? User::where('is_admin', false)->get(['id', 'name']) : null;
        return view('task.index', compact('tasks', 'users', 'is_admin'));
    }

    public function store(TaskRequest $request)
    {
        DB::transaction(function () use ($request) {
            $task = Task::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
                'status_updated_at' => now(),
            ]);
            $task->users()->sync($request->users);
        });
        return redirect()->route('task.index')->with('success', 'Task Added Successfully');
    }

    public function update(TaskRequest $request, Task $task)
    {
        DB::transaction(function () use ($request, $task) {
            if ($task->status != $request->status) {
                $task->status_updated_at = now();
            }
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

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pended,completed,cancelled,in_progress,canceled',
        ]);
        $task->update([
            'status' => $request->status,
            'status_updated_at' => now(),
        ]);
        return redirect()->route('task.index')->with('success', 'Task Status Updated Successfully');
    }
}
