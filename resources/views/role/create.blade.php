@extends('layouts.master')

@section('title', 'Create new role')

@section('content')
    {!! Form::open(array('url' => route('role.store'))) !!}

    {!! Form::label('name', 'Name') !!}{!! Form::text('name') !!}
    <a class="button small round secondary" href="{{ route('role.index') }}">Cancel</a>
    {!! Form::submit('Create role', array('class' => 'button small round success')) !!}

    {!! Form::close() !!}
@stop