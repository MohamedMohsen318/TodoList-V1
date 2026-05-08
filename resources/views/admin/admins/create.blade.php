@extends('layout.default')

@section('title', 'Create Admin')

@section('page')
    <div class="page-center">
        <div class="panel card-wide">
            <div style="margin-bottom: 20px;">
                <h1 style="margin: 0 0 8px; font-size: 30px; font-weight: 800;">Create Admin</h1>
                <p class="helper" style="margin: 0;">Add a new administrator and assign one or more admin roles.</p>
            </div>

            <form action="{{ route('admin.admins.store') }}" method="POST">
                @include('admin.admins._form', ['submitLabel' => 'Create admin'])
            </form>
        </div>
    </div>
@endsection
