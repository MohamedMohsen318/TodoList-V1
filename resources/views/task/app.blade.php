@extends('layout.auth')

@section('title', 'Add Task')

@section('content')
    <div class="card-wide" style="margin: 0 auto;">

        <div style="margin-bottom: 24px;">
            <p class="helper" style="margin-bottom: 6px;">Task Manager</p>
            <h2 style="font-size: 30px; font-weight: 800; margin: 0 0 8px;">Add a new task</h2>
            <p class="helper" style="margin: 0;">Fill in the details below to create a task for your list.</p>
        </div>

        <div class="panel">
            <form action="{{ route('task.store') }}" method="POST" style="display: grid; gap: 16px;">
                @csrf

                <div>
                    <label class="label" for="title">Task title</label>
                    <input class="input" id="title" type="text" name="title"
                           value="{{ old('title') }}"
                           placeholder="e.g. Buy groceries" required>
                    @error('title')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label" for="description">Description</label>
                    <textarea class="input" id="description" name="description"
                              placeholder="Add more details about this task..."
                              rows="4" style="resize: vertical;" required>{{ old('description') }}</textarea>
                    @error('description')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label" for="deadline">Deadline</label>
                    <input class="input" id="deadline" type="date"
                           name="deadline" value="{{ old('deadline') }}" required>
                    @error('deadline')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label" for="status">Status</label>
                    <select class="select" id="status" name="status" required>
                        <option value="">Select status</option>
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display: flex; gap: 10px; margin-top: 4px; flex-wrap: wrap;">
                    <button class="btn btn-primary" type="submit" style="flex: 1;">
                        Save Task
                    </button>
                    <a href="{{ route('welcome') }}" class="btn btn-secondary"
                       style="flex: 1; text-align: center; text-decoration: none;">
                        Back
                    </a>
                </div>

            </form>
        </div>

    </div>
@endsection
