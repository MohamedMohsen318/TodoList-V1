@extends('layout.default')

@section('title', 'Edit Role')

@section('page')
    <div class="page-center">
        <div class="card-wide">
            <div class="panel">
                <div style="margin-bottom: 20px;">
                    <p class="helper" style="margin: 0 0 6px;">Admin Panel</p>
                    <h1 style="font-size: 30px; margin: 0; font-weight: 800;">Edit Role</h1>
                </div>

                <form action="{{ route('admin.roles.update', $role) }}" method="POST" style="display: grid; gap: 18px;">
                    @csrf
                    @method('PUT')

                    @include('admin.roles._form', ['selectedPermissions' => old('permissions', $rolePermissions)])

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-primary">Update Role</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary" style="text-decoration: none;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
