<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TaskMangerController extends Controller
{
    public function listTask(): View
    {
        $this->authorize('viewAny', Tasks::class);

        $tasks = Tasks::where('user_id', auth()->id())
            ->whereIn('status', [TaskStatus::Pending->value, TaskStatus::InProgress->value])
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('task.list', compact('tasks'));
    }

    public function addTask(Request $request): View
    {
        $this->authorize('create', Tasks::class);

        return view('task.app');
    }

    public function addTaskPost(Request $request): RedirectResponse
    {
        $this->authorize('create', Tasks::class);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'status' => ['required', new Enum(TaskStatus::class)],
        ]);

        $task = Tasks::create($data + ['user_id' => auth()->id(),
                'status' => $data['status'],]);

        if ($task) {
            return redirect()->route('tasks.index')
                ->with('success', 'Task added successfully');
        }

        return back()->withErrors('Task not added');
    }

    public function updateTaskStats(Request $request, $id): RedirectResponse
    {
        $task = Tasks::where('user_id', auth()->id())->findOrFail($id);
        $this->authorize('update', $task);

        $status = $request->input('status', $request->query('status', TaskStatus::Completed->value));

        $data = validator(
            ['status' => $status],
            ['status' => ['required', new Enum(TaskStatus::class)]]
        )->validate();

        $updated = $task->update(['status' => $data['status']]);

        if ($updated) {
            return redirect()->route('tasks.index')
                ->with('success', 'Task status updated');
        }

        return redirect()->route('tasks.index')
            ->with('error', 'Task not found or already updated');

    }

    public function deleteTask($id): RedirectResponse
    {
        $task = Tasks::where('user_id', auth()->id())->findOrFail($id);
        $this->authorize('delete', $task);

        $delete = $task->delete();

        if($delete) {
            return redirect()->route('tasks.index')
                ->with('success', 'Task deleted');
        }
        return redirect()->route('tasks.index')
            ->withErrors('Try Again, Task not found or already deleted');

    }

}
