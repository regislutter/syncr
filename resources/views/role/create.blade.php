@extends('layouts.master')

@section('title', 'Create new role')

@section('content')
    <h1>Create new role</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('url' => route('role.store'))) !!}

    {!! Form::label('name', 'Name') !!}{!! Form::text('name') !!}

    <h3>Rights</h3>
    @foreach($rights as $right)
        <label>	{!! Form::checkbox('rights[]', $right->id,  null, ['id' => 'right'.$right->id]) !!} {{ $right->name }}</label>
    @endforeach

    <a class="button small round secondary" href="{{ route('role.index') }}">Cancel</a>
    {!! Form::submit('Create role', array('class' => 'button small round success')) !!}

    {!! Form::close() !!}
@stop