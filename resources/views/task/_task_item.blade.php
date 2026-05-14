@php
    $visited = $visited ?? [];
    $level = $level ?? 0;

    if (in_array($task->id, $visited, true)) {
        return;
    }

    $visited[] = $task->id;
@endphp

<div class="task-item" style="margin-left: {{ $level * 22 }}px;">

    <div style="display: flex; justify-content: space-between; gap: 14px; align-items: start; flex-wrap: wrap;">
        <div>
            <h3 class="task-title">
                {{ $task->title }}
            </h3>

            <p class="task-desc">
                {{ $task->description }}
            </p>
        </div>

        <div class="task-meta">
            <span class="badge deadline">
                Deadline: {{ $task->deadline }}
            </span>

            @php($statusClass = str_replace('_', '-', $task->status?->value ?? 'pending'))
            <span class="badge status-{{ $statusClass }}">
                <span class="dot" aria-hidden="true"></span>
                {{ $task->status?->label() ?? 'Pending' }}
            </span>
        </div>
    </div>

    <div class="task-actions">
        <form action="{{ route('tasks.status.update', $task->id) }}" method="POST" class="status-form">
            @csrf
            @method('PUT')

            <select name="status" aria-label="Task status">
                <option value="pending" @selected(($task->status?->value ?? 'pending') === 'pending')>Pending</option>
                <option value="in_progress" @selected(($task->status?->value ?? 'pending') === 'in_progress')>In Progress</option>
                <option value="completed" @selected(($task->status?->value ?? 'pending') === 'completed')>Completed</option>
            </select>

            <button type="submit" class="btn btn-secondary">
                Update Status
            </button>
        </form>

        <a href="{{ route('tasks.delete', $task->id) }}" class="btn btn-link-danger" style="text-decoration: none;">
            Delete
        </a>
    </div>

</div>

@if($task->relationLoaded('Allchildren') && $task->Allchildren->count())
    @foreach($task->Allchildren as $child)
        @include('task._task_item', ['task' => $child, 'level' => $level + 1, 'visited' => $visited])
    @endforeach
@endif
