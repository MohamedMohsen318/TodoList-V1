@extends('layout.default')

@section('title', 'Roles')

@section('page')
    <div class="page-center">
        <div class="card-wide" style="max-width: 980px;">
            @if(session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif

            <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
                <div>
                    <p class="helper" style="margin: 0 0 6px;">Admin Panel</p>
                    <h1 style="font-size: 32px; margin: 0; font-weight: 800;">Roles</h1>
                </div>

                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary" style="text-decoration: none;">
                        Add Role
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="text-decoration: none;">
                        Back
                    </a>
                </div>
            </div>

            @if($roles->isEmpty())
                <div class="panel" style="text-align: center;">
                    <p style="margin: 0 0 8px; font-weight: 700;">No roles yet</p>
                    <p class="helper" style="margin: 0;">Create your first admin role to organize permissions.</p>
                </div>
            @else
                <div style="display: grid; gap: 14px;">
                    @foreach($roles as $role)
                        <div class="task-item">
                            <div style="display: flex; justify-content: space-between; gap: 12px; align-items: start; flex-wrap: wrap;">
                                <div>
                                    <h3 style="margin: 0 0 8px; font-size: 20px;">{{ $role->name }}</h3>
                                    <p class="helper" style="margin: 0;">
                                        {{ $role->permissions->pluck('name')->implode(', ') ?: 'No permissions assigned yet.' }}
                                    </p>
                                </div>

                                <span class="badge status-in-progress">
                                    {{ $role->permissions->count() }} permissions
                                </span>
                            </div>

                            <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 14px;">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-secondary" style="text-decoration: none;">
                                    Edit
                                </a>

                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Delete this role?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
