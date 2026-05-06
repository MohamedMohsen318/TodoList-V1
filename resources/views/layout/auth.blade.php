@extends('layout.default')

@section('page')
    <div class="page-center">
        <div class="card">
            @if(session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="flash" style="background: #fef2f2; border-color: #fecaca; color: #991b1b;">
                    {{ $errors->first() }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
@endsection
