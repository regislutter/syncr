@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="login-box">
        <div class="row">
            <div class="large-12 columns">
                <form method="POST" action="/auth/register">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="large-12 columns">
                            <input type="text" name="name" placeholder="Name" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 columns">
                            <input type="email" name="email" placeholder="email@lemieuxbedard.com" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 columns">
                            <input type="password" name="password" placeholder="Password" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 columns">
                            <input type="password" name="password_confirmation" placeholder="Confirm password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 large-centered columns">
                            <button type="submit">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <a href="{{ route('auth.login') }}">Back to login</a>
            </div>
        </div>
    </div>
@stop