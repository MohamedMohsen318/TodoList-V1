@extends('layout.default')

@section('title', 'Welcome')

@section('page')
    <div class="page-center">
        <div class="panel card" style="max-width: 560px; text-align: center;">
            @if(session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif

            <h1 style="font-size: 40px; line-height: 1.1; margin: 0 0 12px; font-weight: 800;">
                Welcome, {{ auth()->user()->name }}
            </h1>
            <p class="helper" style="font-size: 16px; margin: 0 0 24px;">
                Manage your tasks and stay on top of your deadlines.
            </p>

            <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
                <a href="{{ route('task.create') }}" class="btn btn-primary" style="text-decoration: none;">
                    Add Task
                </a>

                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button class="btn btn-danger" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>
@endsection
