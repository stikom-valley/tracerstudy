@extends('layouts.begin_auth')

@section('title', 'Login')

@section('content')
@if ($errors->any())
<div class="alert alert-warning alert-has-icon">
    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
    <div class="alert-body">
        <div class="alert-title">Caution</div>
        @foreach ($errors->all() as $item)
        <li>{{ $item }}</li>
        @endforeach
    </div>
</div>
@endif
@include('frontend.include.alert')
<div class="card card-primary">
    <div class="card-header">
        <h4>Hello, silahkan masuk dengan akun Anda!</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" value="{{ old('email') }}" class="form-control" name="email" tabindex="1" autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control" name="password" tabindex="2">
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                    <label class="custom-control-label" for="remember-me">Ingat Saya?</label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Masuk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection