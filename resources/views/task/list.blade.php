@extends('layout.default')

@section('title', 'Task List')

@section('page')
    <style>
        .pagination {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .pagination svg {
            width: 16px;
            height: 16px;
        }

        .pagination-wrap nav {
            width: 100%;
        }

        .pagination-wrap .hidden.sm\:flex-1,
        .pagination-wrap .sm\:hidden {
            display: none !important;
        }

        .pagination-wrap .hidden.sm\:flex.sm\:items-center.sm\:justify-between {
            display: flex !important;
            justify-content: center !important;
        }

        .pagination-wrap .hidden.sm\:flex.sm\:items-center.sm\:justify-between > div:last-child > span,
        .pagination-wrap .hidden.sm\:flex.sm\:items-center.sm\:justify-between > div:last-child > a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 14px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
        }

        .pagination-wrap .hidden.sm\:flex.sm\:items-center.sm\:justify-between > div:last-child > span[aria-current="page"] {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: 42px;
            min-width: 42px;
            height: 42px;
            padding: 0 !important;
            border-radius: 999px !important;
            border: 2px solid #1d4ed8 !important;
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.32) !important;
        }

        .pagination-wrap .hidden.sm\:flex.sm\:items-center.sm\:justify-between > div:last-child > span[aria-current="page"] span {
            color: #ffffff !important;
            font-weight: 700 !important;
            line-height: 1 !important;
        }

        .pagination-wrap .hidden.sm\:flex.sm\:items-center.sm\:justify-between > div:last-child > span[aria-current="page"],
        .pagination-wrap .hidden.sm\:flex.sm\:items-center.sm\:justify-between > div:last-child > span[aria-current="page"] > span,
        .pagination-wrap .hidden.sm\:flex.sm\:items-center.sm\:justify-between > div:last-child > span.bg-white {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 14px;
            border-radius: 999px;
            border: 2px solid #1d4ed8;
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.32);
        }

        .pagination-wrap .hidden.sm\:flex.sm\:items-center.sm\:justify-between > div:last-child {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
        }

        .task-item {
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 18px 18px 14px;
            background: #ffffff;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.06);
        }

        .task-item + .task-item {
            margin-top: 14px;
        }

        .task-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .task-title {
            margin: 0 0 6px;
            font-size: 18px;
            font-weight: 850;
            letter-spacing: -0.02em;
        }

        .task-desc {
            margin: 0;
            color: #475569;
            line-height: 1.55;
            max-width: 64ch;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 800;
            font-size: 12px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #0f172a;
        }

        .badge .dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #94a3b8;
        }

        .badge.deadline {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #9a3412;
        }

        .badge.status-pending {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #0f172a;
        }

        .badge.status-pending .dot {
            background: #64748b;
        }

        .badge.status-in-progress {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #1d4ed8;
        }

        .badge.status-in-progress .dot {
            background: #2563eb;
        }

        .badge.status-completed {
            background: #ecfdf5;
            border-color: #a7f3d0;
            color: #047857;
        }

        .badge.status-completed .dot {
            background: #10b981;
        }

        .task-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px dashed #e2e8f0;
            flex-wrap: wrap;
        }

        .status-form {
            display: inline-flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .status-form select {
            height: 42px;
            min-width: 170px;
            padding: 0 12px;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #0f172a;
            font-weight: 700;
        }

        .btn.btn-link-danger {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #be123c;
        }

        .btn.btn-link-danger:hover {
            filter: brightness(0.98);
        }
    </style>
    <div class="page-center">
        <div class="card-wide">

            @if(session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif

            <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
                <div>
                    <p class="helper" style="margin: 0 0 6px;">Task Manager</p>
                    <h1 style="font-size: 32px; margin: 0; font-weight: 800;">Your tasks</h1>
                </div>

                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary" style="text-decoration: none;">
                        Add Task
                    </a>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary" style="text-decoration: none;">
                        Back
                    </a>
                </div>
            </div>

            {{-- TASK LIST --}}
            @if($tasks->count() === 0)
                <div class="panel" style="text-align: center;">
                    <p style="margin: 0 0 8px; font-weight: 700;">No tasks yet</p>
                    <p class="helper" style="margin: 0;">Create your first task to see it listed here.</p>
                </div>
            @else
                <div class="task-list">

                    @foreach($tasks as $task)
                        <div class="task-item">

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
                    @endforeach

                </div>
                    <div style="margin-top: 24px; display: flex; justify-content: center;">
                        <div class="pagination-wrap" style="display: flex; gap: 6px; padding: 8px 12px; border-radius: 14px; background: rgba(255, 255, 255, 0.96); border: 1px solid #dbe3f0; box-shadow: 0 12px 28px rgba(15, 23, 42, 0.05);">
                            {{ $tasks->links() }}
                        </div>
                    </div>
            @endif
        </div>
    </div>
@endsection
