@extends('layout.default')

@section('title', 'Manage Admins')

@section('page')
    <div class="page-center" style="align-items: stretch;">
        <div class="panel card-wide" style="max-width: 980px;">
            <div style="display: flex; justify-content: space-between; gap: 16px; align-items: center; margin-bottom: 20px; flex-wrap: wrap;">
                <div>
                    <h1 style="margin: 0 0 8px; font-size: 30px; font-weight: 800;">Admins</h1>
                    <p class="helper" style="margin: 0;">Only admin and super_admin accounts can access this page and manage admin users.</p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Dashboard</a>
                </div>
            </div>

            @if(session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="flash" style="background: #fef2f2; border-color: #fecaca; color: #991b1b;">
                    {{ $errors->first() }}
                </div>
            @endif

            @can('create-admin')
                <div class="panel" style="margin-bottom: 20px;">
                    <div style="margin-bottom: 16px;">
                        <h2 style="margin: 0 0 8px; font-size: 24px; font-weight: 800;">Add New Admin</h2>
                        <p class="helper" style="margin: 0;">Create an admin مباشرة من نفس الصفحة بدون التنقل لصفحة أخرى.</p>
                    </div>

                    <form action="{{ route('admin.admins.store') }}" method="POST">
                        @include('admin.admins._form', ['submitLabel' => 'Create admin'])
                    </form>
                </div>
            @endcan

            <div style="display: grid; gap: 14px;">
                @foreach($admins as $admin)
                    <div class="task-item">
                        <div style="display: flex; justify-content: space-between; gap: 12px; align-items: start; flex-wrap: wrap;">
                            <div>
                                <h3 style="margin: 0 0 6px;">{{ $admin->name }}</h3>
                                <p class="helper" style="margin: 0 0 8px;">{{ $admin->email }}{{ $admin->phone ? ' | '.$admin->phone : '' }}</p>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    @foreach($admin->roles as $role)
                                        <span class="badge status-in-progress">{{ $role->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                @can('edit-admin')
                                    <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-secondary">Edit</a>
                                @endcan

                                @can('delete-admin')
                                    <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" onsubmit="return confirm('Delete this admin?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 18px;">
                {{ $admins->links() }}
            </div>
        </div>
    </div>
@endsection
