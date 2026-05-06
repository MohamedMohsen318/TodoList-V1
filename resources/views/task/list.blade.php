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
                    <a href="{{ route('task.create') }}" class="btn btn-primary" style="text-decoration: none;">
                        Add Task
                    </a>
                    <a href="{{ route('welcome') }}" class="btn btn-secondary" style="text-decoration: none;">
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

                            <div style="display: flex; justify-content: space-between; gap: 12px; align-items: start; flex-wrap: wrap;">
                                <div>
                                    <h3 style="margin: 0 0 8px; font-size: 20px;">
                                        {{ $task->title }}
                                    </h3>

                                    <p class="helper" style="margin: 0 0 12px;">
                                        {{ $task->description }}
                                    </p>
                                </div>

                                <div style="display: flex; gap: 8px; flex-wrap: wrap; justify-content: flex-end;">
                                <span class="badge status-pending">
                                    Deadline: {{ $task->deadline }}
                                </span>

                                    <span class="badge status-{{ str_replace('_', '-', $task->status ?? 'pending') }}">
                                    {{ ucfirst(str_replace('_', ' ', $task->status ?? 'pending')) }}
                                </span>
                                </div>
                            </div>

                            <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 14px;">
                                <a href="{{ route('task.status.update', $task->id) }}" class="btn btn-secondary" style="text-decoration: none;">
                                    Update Status
                                </a>

                                <a href="{{ route('task.delet', $task->id) }}" class="btn btn-danger" style="text-decoration: none;">
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
