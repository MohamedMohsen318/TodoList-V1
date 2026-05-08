@extends('layout.default')

@section('title', 'Edit Admin')

@section('page')
    <div class="page-center">
        <div class="panel card-wide">
            <div style="margin-bottom: 20px;">
                <h1 style="margin: 0 0 8px; font-size: 30px; font-weight: 800;">Edit Admin</h1>
                <p class="helper" style="margin: 0;">Update the admin account and adjust its role assignments.</p>
            </div>

            <form action="{{ route('admin.admins.update', $admin) }}" method="POST">
                @method('PUT')
                @include('admin.admins._form', ['submitLabel' => 'Save changes'])
            </form>
        </div>
    </div>
@endsection
