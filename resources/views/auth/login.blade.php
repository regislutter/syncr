@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="login-box">
        <div class="row">
            <div class="large-12 columns">
                <form method="POST" action="/auth/login">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="large-12 columns">
                            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 columns">
                            <input type="password" name="password" placeholder="Password" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 columns">
                            <input type="checkbox" name="remember"> Remember Me
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 large-centered columns">
                            <button type="submit">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <a href="{{ route('auth.register') }}">Register</a>
            </div>
        </div>
    </div>
@stop