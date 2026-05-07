<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class TaskMangerController extends Controller
{
    function listTask()
    {
        $tasks = Tasks::where('user_id', auth()->id())
            ->whereIn('status', [TaskStatus::Pending->value, TaskStatus::InProgress->value])
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('task.list', compact('tasks'));
    }
    function addTask(Request $request)
    {
        return view('task.app');
    }
    function addTaskPost(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'status' => ['required', new Enum(TaskStatus::class)],
        ]);

        $task = Tasks::create($data + ['user_id' => auth()->id(),
                'status' => TaskStatus::Completed,]);

//        $data['user_id'] = auth()->id();
//        $task = Tasks::create($data);

        if ($task) {
            return redirect()->route('task.index')
                ->with('success', 'Task added successfully');
        }

        return back()->withErrors('Task not added');
    }
    function updateTaskStats( $id)
    {
        $updated = Tasks::where('user_id', auth()->id())
            ->where('id', $id)
            ->update(['status' => TaskStatus::Completed->value]);

        if ($updated) {
            return redirect()->route('task.index')
                ->with('success', 'Task completed');
        }

        return redirect()->route('task.index')
            ->with('error', 'Task not found or already updated');

    }
    function deleteTask($id){
        $delete = Tasks::where('user_id', auth()->id())
            ->where('id', $id)
            ->delete();
        if($delete) {
            return redirect()->route('task.index')
                ->with('success', 'Task deleted');
        }
        return redirect()->route('task.index')
            ->withErrors('Try Again, Task not found or already deleted');

    }

}
