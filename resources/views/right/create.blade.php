@extends('layouts.master')

@section('title', 'Create new right')

@section('content')
    <h1>Create new right</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('url' => route('right.store'))) !!}

    {!! Form::label('name', 'Name') !!}{!! Form::text('name') !!}
    <a class="button small round secondary" href="{{ route('right.index') }}">Cancel</a>
    {!! Form::submit('Create right', array('class' => 'button small round success')) !!}

    {!! Form::close() !!}
@stop