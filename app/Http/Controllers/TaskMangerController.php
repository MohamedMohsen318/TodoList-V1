<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;

class TaskMangerController extends Controller
{
    function listTask()
    {
        $tasks = Tasks::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'in_progress'])
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
            'status' => 'required|string|max:255',
        ]);

        $data['user_id'] = auth()->id();

        $task = Tasks::create($data);

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
            ->update(['status' => 'completed']);

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
