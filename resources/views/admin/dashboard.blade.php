@extends('layout.default')

@section('title', 'Admin Dashboard')

@section('page')
    <div class="layout">
        <aside class="sidebar">
            <h2 style="margin: 0 0 10px; font-size: 24px; font-weight: 800;">Admin Panel</h2>
            <p class="helper" style="margin: 0 0 24px;">Signed in as {{ $admin->name }}</p>

            <a href="{{ route('admin.dashboard') }}" class="nav-link active">Dashboard</a>

            @if($admin->can('view-users'))
                <a href="{{ route('admin.admins.index') }}" class="nav-link">Manage Admins</a>
            @endif

            @if($admin->can('manage-roles'))
                <a href="{{ route('admin.roles.index') }}" class="nav-link">Manage Roles</a>
            @endif

            <form action="{{ route('admin.logout') }}" method="POST" style="margin-top: 18px;">
                @csrf
                <button class="btn btn-danger" type="submit" style="width: 100%;">Logout</button>
            </form>
        </aside>

        <main class="content">
            @if(session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif

            <div class="panel" style="margin-bottom: 18px;">
                <h1 style="margin: 0 0 8px; font-size: 34px; font-weight: 800;">
                    {{ $admin->hasRole('super_admin') ? 'Super Admin Dashboard' : 'Admin Dashboard' }}
                </h1>
                <p class="helper" style="margin: 0;">
                    {{ $admin->hasRole('super_admin') ? 'You have full access to users, admins, roles, and permissions.' : 'You can manage the areas granted to your admin role.' }}
                </p>
            </div>

            <div class="stats">
                <div class="stat-box">
                    <p class="helper">Users</p>
                    <h3 style="margin: 6px 0 0; font-size: 28px;">{{ $stats['users'] }}</h3>
                </div>
                <div class="stat-box">
                    <p class="helper">Admins</p>
                    <h3 style="margin: 6px 0 0; font-size: 28px;">{{ $stats['admins'] }}</h3>
                </div>
                <div class="stat-box">
                    <p class="helper">Tasks</p>
                    <h3 style="margin: 6px 0 0; font-size: 28px;">{{ $stats['tasks'] }}</h3>
                </div>
                <div class="stat-box">
                    <p class="helper">Completed Tasks</p>
                    <h3 style="margin: 6px 0 0; font-size: 28px;">{{ $stats['completed_tasks'] }}</h3>
                </div>
            </div>
        </main>
    </div>
@endsection
