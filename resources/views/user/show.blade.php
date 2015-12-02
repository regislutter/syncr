@extends('layouts.master')

@section('title', 'My Profile')

@section('content')

    <div class="row">
        @if(isset($user->avatar))
        <div class="large-2 columns">
            <img class="avatar" src="/images/users/{{ $user->avatar }}" />
        </div>
        <div class="large-10 columns">
        @else
        <div class="large-12 columns">
        @endif
            <div class="row">
                <div class="large-12 columns">
                    Name: {{ $user->name }}
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    Email: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                </div>
            </div>
            @if(isset($user->title) && !empty($user->title))
            <div class="row">
                <div class="large-12 columns">
                    Title/Job: {{ $user->title }}
                </div>
            </div>
            @endif
            @if(isset($user->phone) && !empty($user->phone) || isset($user->phonepost) && !empty($user->phonepost))
            <div class="row">
                <div class="large-12 columns">
                    @if(isset($user->phone) && !empty($user->phone)) Phone: {{ $user->phone }} @endif
                    @if(isset($user->phone) && !empty($user->phone) && isset($user->phonepost) && !empty($user->phonepost)) - @endif
                    @if(isset($user->phonepost) && !empty($user->phonepost)) Internal post : {{ $user->phonepost }} @endif
                </div>
            </div>
            @endif
            @if(isset($user->hobbies) && !empty($user->hobbies))
            <div class="row">
                <div class="large-12 columns">
                    Hobbies: {{ $user->hobbies }}
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($user->id == Auth::user()->id)
        <a class="button small round" href="{{ route('user.edit', $user->id) }}">Edit my profile</a>
    @elseif(Auth::user()->is(\App\Role::ADMIN) || Auth::user()->is(\App\Role::SUPER_ADMIN))
        <a class="button small round" href="{{ route('user.edit', $user->id) }}">Edit user</a>
    @endif

@stop