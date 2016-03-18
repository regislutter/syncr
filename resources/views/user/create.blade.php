@extends('layouts.master')

@section('title', 'Create user')

@section('content')
    <h1>Create user:</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('url' => route('user.store'), 'files' => true)) !!}

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

    {!! Form::label('hobbies', 'Hobbies') !!}{!! Form::textarea('hobbies', null, ['rows' => '3']) !!}

    <div class="row">
        <div class="large-1 columns">{!! Form::label('avatar', 'Avatar') !!}</div>
        <div class="large-11 columns">{!! Form::file('avatar') !!}</div>
    </div>

    @if(\Auth::user()->hasRight(\App\Right::USER_CHANGE_ROLES))
        <h3>Roles</h3>
        @foreach($roles as $role)
            <label>	{!! Form::checkbox('roles[]', $role->id,  null, ['id' => 'role'.$role->id]) !!} {{ $role->name }}</label>
        @endforeach
    @endif

    <a class="button small round secondary" href="{{ route('admin.users') }}">Cancel</a>
    {!! Form::submit('Create user', array('class' => 'button small round success')) !!}
    {!! Form::close() !!}
@stop