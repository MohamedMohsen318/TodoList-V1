@extends('layout.default')

@section('title', 'User Dashboard')

@section('page')
    <div class="layout">
        <aside class="sidebar">
            <h2 style="margin: 0 0 10px; font-size: 24px; font-weight: 800;">User Panel</h2>
            <p class="helper" style="margin: 0 0 24px;">Welcome back, {{ $user->name }}</p>

            <a href="{{ route('user.dashboard') }}" class="nav-link active">Dashboard</a>
            <a href="{{ route('tasks.create') }}" class="nav-link">Create Task</a>
            <a href="{{ route('tasks.index') }}" class="nav-link">My Tasks</a>

            <form action="{{ route('logout') }}" method="POST" style="margin-top: 18px;">
                @csrf
                <button class="btn btn-danger" type="submit" style="width: 100%;">Logout</button>
            </form>
        </aside>

        <main class="content">
            @if(session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif

            <div class="panel" style="margin-bottom: 18px;">
                <h1 style="margin: 0 0 8px; font-size: 34px; font-weight: 800;">Your Dashboard</h1>
                <p class="helper" style="margin: 0;">Track your own tasks and keep daily progress clear.</p>
            </div>

            <div class="stats">
                <div class="stat-box">
                    <p class="helper">All Tasks</p>
                    <h3 style="margin: 6px 0 0; font-size: 28px;">{{ $stats['all'] }}</h3>
                </div>
                <div class="stat-box">
                    <p class="helper">Pending</p>
                    <h3 style="margin: 6px 0 0; font-size: 28px;">{{ $stats['pending'] }}</h3>
                </div>
                <div class="stat-box">
                    <p class="helper">In Progress</p>
                    <h3 style="margin: 6px 0 0; font-size: 28px;">{{ $stats['in_progress'] }}</h3>
                </div>
                <div class="stat-box">
                    <p class="helper">Completed</p>
                    <h3 style="margin: 6px 0 0; font-size: 28px;">{{ $stats['completed'] }}</h3>
                </div>
            </div>
        </main>
    </div>
@endsection
