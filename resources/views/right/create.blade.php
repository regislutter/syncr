@extends('layouts.master')

@section('title', 'Create new right')

@section('content')
    {!! Form::open(array('url' => route('right.store'))) !!}

    {!! Form::label('name', 'Name') !!}{!! Form::text('name') !!}
    <a class="button small round secondary" href="{{ route('right.index') }}">Cancel</a>
    {!! Form::submit('Create right', array('class' => 'button small round success')) !!}

    {!! Form::close() !!}
@stop