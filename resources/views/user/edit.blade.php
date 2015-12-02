@extends('layouts.master')

@section('title', 'Modify user')

@section('content')
    <h1>Modify user: {{ $user->name }}</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::model($user, array('route' => array('user.update', $user->id), 'files' => true, 'method' => 'put')) !!}

    {!! Form::label('name', 'Name') !!}{!! Form::text('name') !!}
    {!! Form::label('email', 'Email') !!}{!! Form::email('email') !!}
    {!! Form::label('title', 'Title/Job') !!}{!! Form::text('title') !!}

    <div class="row">
        <div class="large-2 columns">{!! Form::label('phone', 'Phone number') !!}</div>
        <div class="large-4 columns">{!! Form::text('phone') !!}</div>
        <div class="large-2 columns">{!! Form::label('phonepost', 'Internal phone post') !!}</div>
        <div class="large-4 columns">{!! Form::text('phonepost') !!}</div>
    </div>
    <br/>

    {!! Form::label('hobbies', 'Hobbies') !!}{!! Form::textarea('hobbies', $user->hobbies, ['rows' => '3']) !!}

    <div class="row">
        <div class="large-1 columns">{!! Form::label('avatar', 'Avatar') !!}</div>
        <div class="large-5 columns">{!! Form::file('avatar') !!}</div>
        <div class="large-1 columns">Actual:</div>
        <div class="large-5 columns">
            @if(isset($user->avatar))
                <img class="avatar" src="/images/users/{{ $user->avatar }}" />
                @else
                No picture yet.
            @endif
        </div>
    </div>

    @if(\Auth::user()->hasRight(\App\Right::USER_CHANGE_ROLES))
    <h3>Roles</h3>
    @foreach($roles as $role)
        @if($user->is($role->id))
        <label>	{!! Form::checkbox('roles[]', $role->id,  true, ['id' => 'role'.$role->id]) !!} {{ $role->name }}</label>
        @else
        <label>	{!! Form::checkbox('roles[]', $role->id,  null, ['id' => 'role'.$role->id]) !!} {{ $role->name }}</label>
        @endif
    @endforeach
    @endif

    <a class="button small round secondary" href="{{ route('user.index') }}">Cancel</a>
    {!! Form::submit('Save user', array('class' => 'button small round success')) !!}
    {!! Form::close() !!}
@stop